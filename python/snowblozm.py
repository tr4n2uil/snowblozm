###
 #	@module snowblozm
 #
 #	@type iObject, iArray, iString, iRegistry
 #	@desc universal message object, workflow array, navigator string and reference registry container
 #
 #	@author Vibhaj Rajan <vibhaj8@gmail.com>
 #
###

import sys
import types

debug = False
registry = {}

# 	snowblozm iobject
class iobject( dict ):

	#	Runs a message object
	def run( self, memory = {} ):
		if not self.get( 'service', None ):
			print 'No Service Specified'
			return { 'valid': False }
		
		#	Read the service instance
		if type( self.service ) is not types.StringType:
			self.service.load()
		
		#	Read the service arguments
		self.args = self.get( 'args', [] )
		
		#	Copy arguments if necessary
		for i in self.args:
			key = self.args[ i ]
			self[ key ] = self.get( key, memory.get( key, None ) )
		
		#	Read the service input
		self.input = self.get( 'input', {} )
		sin = self.service.input()
		sinreq = sin.get( 'required', [] )
		sinopt = sin.get( 'optional', {} )
		
		#	Set the index values
		if sin.get( 'set', None ):
			sinset = sin['set']
			max = len( sinset )
			for i in range(0, max):
				key = sinset[ i ]
				self[ key ] = self.get( key, self.get( i, memory.get( i, None ) ) )
		
		#	Copy required input if not exists (return valid false if value not found)
		for i in sinreq:
			key = sinreq[ i ]
			param = self.input.get( key, key )
			self[ key ] = self.get( key, memory.get( param, None ) )
			if not self[ key ]:
				memory[ 'valid' ] = False
				if debug:
					print "Value not found for ", key
				return memory
		
		#	Copy optional input if not exists
		for key in sinopt:
			param = self.input.get( key, key )
			self[ key ] = self.get( key, memory.get( param, sinopt.get( key, None ) ) )
		
		#	Run the service with the message as memory
		try:
			result = self.service.run( self )
		except:
			print "Exception:", sys.exc_info()[0]
			return { 'valid': false }
		
		#	Read the service output and return if not valid
		memory[ 'valid' ] = result.get( 'valid', False )
		if memory[ 'valid' ]:
			self.output = self.get( 'output', [] )
		else:
			return memory
		sout = self.service.output()
		
		#	Copy output
		for i in sout:
			key = sout[ i ]
			param = self.output.get( key, key )
			memory[ param ] = result.get( key, False )
		
		#	Return the memory
		return memory

# 	snowblozm iarray
class iarray( list ):

	#	Executes a workflow array
	def execute( self, memory = {} ):
		#	initialize memory if not
		memory[ 'valid' ] = memory.get( 'valid', True )

		for i in self:
			message = self[ i ]
			
			#	Check for non strictness
			nonstrict = message.get( 'nonstrict', False )
			
			#	Continue on invalid state if non-strict
			if not memory[ 'valid' ] and not nonstrict:
				continue
			
			#	run the service with the message and memory
			memory = message.run( memory )
		
		return memory

# 	snowblozm istring
class istring( str ):

	#	Launches a navigator string
	def launch( self, memory ):
		message = { 'navigator' : self }
		
		if self[ 1 ] == '/':
			#	Parse navigator
			parts = self.split('~')
			
			path = parts[ 0 ].split('/')
			index = path.pop( 0 ) + path.pop( 0 )
			
			#	Construct message for workflow
			message[ 'service' ] = index
			for j in path:
				#	path[j] = unescape(path[j])
				message[ j ] = path[ j ]
			
			if parts.get( 1 ):
				req = parts[ 1 ].split('/')
				for i in range( 1, len( req ), 2 ):
					#	req[i + 1] = unescape(req[i + 1])
					message[ req[ i ] ] = req[ i + 1 ]
		
		else:
			navigator = self
			#navigator = navigator.replace(/_/g, '#')
			#navigator = navigator.replace(/\./g, '=')
			
			#	Parse navigator
			req = navigator.split(':')
			index = req[0]
			
			#	Construct message for workflow
			message[ 'service' ] = index
			for i in range( 1, len( req ) ):
				param = ( req[ i ] ).split('=')
				arg = param[1]
				# 	arg = arg.replace(/~/g, '=')
				# 	arg = unescape(arg)
				message[ param[ 0 ] ] = arg
		
		#	Run the workflow and return the valid value
		memory = message.run( memory )
		return memory[ 'valid' ]

# 	snowblozm iregistry
class iregistry( str ):

	#	Saves a reference
	def save( self, value ):
		registry[ self ] = value
	
	#	Gets a reference
	def get( self ):
		return registry.get( self, None )
	
	#	Loads a service reference
	def load( self ):
		service = self.get() or self
		parts = service.split( '.' )
		class_name = parts.pop( len( parts ) - 1 )
		module = '.'.join( parts )
		module = __import__( module, fromlist = [ class_name ] )
		return getattr( module, class_name )()
	
	#	Delete a reference
	def rem( self ):
		del registry[ self ]
