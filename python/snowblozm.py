###
 #	@module snowblozm
 #
 #	@type iObject, iArray, iString, iRegistry, iService
 #	@desc universal message object, workflow array, navigator string, reference registry and scalable service container
 #
 #	@author Vibhaj Rajan <vibhaj8@gmail.com>
 #
###

import sys
import types

debug = False
registry = {}

#	snowblozm iservice
class iService():
	
	#	Input parameters
	def input( self ):
		raise "Not Implemented Yet"
	
	#	Service functionality
	def run( self, memory ):
		raise "Not Implemented Yet"
	
	#	Output parameters
	def output( self ):
		raise "Not Implemented Yet"

# 	snowblozm iobject
class iObject( dict ):

	#	Runs a message object
	def run( self, memory = {} ):
		service = self.get( 'service', None )
		if not service:
			print 'No Service Specified'
			return { 'valid': False }
		
		#	Read the service instance
		if type( service ) is types.StringType:
			service = iRegistry( service ).load()
		
		#	Read the service arguments
		self.args = self.get( 'args', [] )
		
		#	Copy arguments if necessary
		for i in self.args:
			key = self.args[ i ]
			self.setdefault( key, memory.get( key, None ) )
		
		#	Read the service input
		self.input = self.get( 'input', {} )
		sin = service.input()
		sinreq = sin.get( 'required', [] )
		sinopt = sin.get( 'optional', {} )
		
		#	Set the index values
		if sin.get( 'set', None ):
			sinset = sin['set']
			max = len( sinset )
			for i in range(0, max):
				key = sinset[ i ]
				self.setdefault( key, self.get( i, memory.get( i, None ) ) )
				
		#	Copy required input if not exists (return valid false if value not found)
		for key in sinreq:
			# key = sinreq[ i ]
			param = self.input.get( key, key )
			self.setdefault( key, memory.get( param, None ) )
			if not self[ key ]:
				memory[ 'valid' ] = False
				if debug:
					print "Value not found for ", key
				return memory
		
		#	Copy optional input if not exists
		for key in sinopt:
			param = self.input.get( key, key )
			self.setdefault( key, memory.get( param, sinopt.get( key, None ) ) )
		
		# 	Remove numeric keys
		nkeys = []
		for key in self:
			if type( key ) is not types.StringType:
				nkeys.append( key )
		for key in nkeys:
				del self[ key ]
		
		#	Run the service with the message as memory
		try:
			result = service.run( **self )
		except:
			print "Exception:", sys.exc_info()
			return { 'valid': False }
		
		#	Read the service output and return if not valid
		memory[ 'valid' ] = result.get( 'valid', False )
		if memory[ 'valid' ]:
			self.output = self.get( 'output', [] )
		else:
			return memory
		sout = service.output() + [ 'msg', 'details', 'status' ]
		
		#	Copy output
		self.output = self.get( 'output', {} )
		for key in sout:
			param = self.output.get( key, key )
			memory[ param ] = result.get( key, False )
		
		#	Return the memory
		return memory
		
	# 	setdefault override
	def setdefault( self, key, value = None ):
		if key not in self or not self[ key ]:
			self[ key ] = value
		return self[ key ]

# 	snowblozm iarray
class iArray( list ):

	#	Executes a workflow array
	def execute( self, memory = {} ):
		#	initialize memory if not
		memory[ 'valid' ] = memory.get( 'valid', True )

		for message in self:
			#message = self[ i ]
			
			#	Check for non strictness
			nonstrict = message.get( 'nonstrict', False )
			
			#	Continue on invalid state if non-strict
			if not memory[ 'valid' ] and not nonstrict:
				continue
			
			#	run the service with the message and memory
			memory = iObject( message ).run( memory )
		
		return memory

# 	snowblozm istring
class iString( str ):

	#	Launches a navigator string
	def launch( self, memory = {} ):
		message = iObject( { 'navigator' : self } )
		
		if self[ 0 ] == '/':
			#	Parse navigator
			parts = self.split('~')
			
			path = parts[ 0 ].split('/')
			index = path.pop( 0 ) + path.pop( 0 )
			
			#	Construct message for workflow
			message[ 'service' ] = index
			j = 0
			for val in path:
				#	path[j] = unescape(path[j])
				message[ j ] = val
				j = j + 1
			
			if len( parts ) > 1:
				req = parts[ 1 ].split('/')
				for i in range( 1, len( req ) - 1, 2 ):
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
class iRegistry( str ):

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

#	snowblozm utils		
def utils( memory = {}, valid = True, msg = 'Successfully Executed', details = 'Successfully Executed', status = 200 ):
	memory[ 'valid' ] = valid
	memory[ 'msg' ] = msg
	memory[ 'details' ] = details
	memory[ 'status' ] = status
	return memory
