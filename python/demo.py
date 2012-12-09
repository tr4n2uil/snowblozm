### #	@module demo # #	@author Vibhaj Rajan <vibhaj8@gmail.com> ####import sysimport snowblozm#	demo greet serviceclass Greet( snowblozm.iService ):	def input( self ):		return { 			'optional': { 				'name': 'Krishna' 			}, 			'set': [ 'name' ] 		}		def run( self, name, *args, **memory ):		print 'Hello World', name, '!'		return snowblozm.utils( memory )		def output( self ):		return []#	testing demodef main():	name = sys.argv[ 1 ] if len( sys.argv ) > 1 else ''		#	test iRegistry	snowblozm.iRegistry( 'greet' ).save( 'demo.Greet' )		#	test iObject	message = snowblozm.iObject( { 		'service': 'demo.Greet',		'name' : name	} )	memory = message.run()	print '\nmessage: ', memory, '\n'		#	test iArray	workflow = snowblozm.iArray( [{ 		'service': 'demo.Greet',		'name' : name	}, { 		'service': 'greet',		'name' : 'Hari'	}] )	memory = workflow.execute()	print '\nworkflow: ', memory, '\n'		#	test iString	navigator = snowblozm.iString( '/greet/' + name + '/' )	status = navigator.launch()	print '\nnavigator 1: ', status, '\n'		navigator = snowblozm.iString( '/greet/~/name/' + name + '/' )	status = navigator.launch()	print '\nnavigator 2: ', status, '\n'if __name__ == "__main__":    main()