/**
 *	@module snowblozm	
 *
 *	@type iObject, iArray, iString, iRegistry
 *	@desc universal message object, workflow array, navigator string and reference registry container
 *
 *	@extend Object, Array and String
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
( function( window, undefined ){

	/**
	 *	Runs a message object
	**/
	Object.defineProperty( Object.prototype, "run", { 
		value: function( memory ){
			/**
			 *	create a new memory if not passed
			**/
			memory = memory || {};
			
			/**
			 *	Read the service instance
			**/
			if( this.service.constructor == String ){
				this.service = this.service.get();
			}
			
			/**
			 *	Read the service arguments
			**/
			this.args = this.args || [];
			
			/**
			 *	Copy arguments if necessary
			**/
			for( var i in this.args ){
				var key = this.args[ i ];
				this[ key ] = this[ key ] || memory[ key ] || undefined;
			}
			
			/**
			 *	Read the service input
			**/
			this.input = this.input || {};
			var sin = this.service.input();
			var sinreq = sin[ 'required' ] || [];
			var sinopt = sin[ 'optional' ] || {};
			
			/**
			 *	Set the index values
			**/
			if( sin[ 'set' ] || false){
				var sinset = sin['set'];
				var max = sinset.length;
				for( i=0; i<max; i++ ){
					var key = sinset[ i ];
					this[ key ] = this[ key ] || this[ i ] || memory[ i ] || undefined;
				}
			}
			
			/**
			 *	Copy required input if not exists (return valid false if value not found)
			**/
			for( var i in sinreq ){
				var key = sinreq[ i ];
				var param = this.input[ key ] || key;
				this[ key ] = this[ key ] || memory[ param ] || undefined;
				if( this[ key ] === undefined ){
					memory[ 'valid' ] = undefined;
					if( window.debug || undefined ){
						alert( "Value not found for " + key );
					}
					return memory;
				}
			}
			
			/**
			 *	Copy optional input if not exists
			**/
			for( var key in sinopt ){
				var param = this.input[ key ] || key;
				this[ key ] = this[ key ] || memory[ param ] || sinopt[ key ];
			}
			
			/**
			 *	Run the service with the message as memory
			**/
			try {
				var result = this.service.run( this );		
			} catch(id) {
				if(console || false){
					console.log('Exception : ' + id);
				}
				return { valid: false };
			}
			
			/**
			 *	Read the service output and return if not valid
			**/
			memory[ 'valid' ] = result[ 'valid' ] || undefined;
			if( memory[ 'valid' ] ){
				this.output = this.output || [];
			}
			else {
				return memory;
			}
			var sout = this.service.output();
			
			/**
			 *	Copy output
			**/
			for( var i in sout ){
				var key = sout[ i ];
				var param = this.output[ key ] || key;
				memory[ param ] = result[ key ] || undefined;
			}
			
			/**
			 *	Return the memory
			**/
			return memory;
		}
	} );
	
	/**
	 *	Executes a workflow array
	**/
	Object.defineProperty( Array.prototype, "execute", { 
		value: function( memory ){
			/**
			 *	create a new memory if not passed
			**/
			memory = memory || {};
			memory[ 'valid' ] = memory[ 'valid' ] || true;
		
			for( var i in this ){
				var message = this[ i ];
				
				/**
				 *	Check for non strictness
				**/
				var nonstrict = message[ 'nonstrict' ] || undefined;
				
				/**
				 *	Continue on invalid state if non-strict
				**/
				if( memory[ 'valid' ] !== true && nonstrict !== true )
					continue;
				
				/**
				 *	run the service with the message and memory
				**/
				memory = message.run( memory );
			}
			
			return memory;
		}
	} );
	
	/**
	 *	Launches a navigator string
	**/
	Object.defineProperty( String.prototype, "launch", { 
		value: function( memory ){
			var message = {
				navigator : this
			};
			
			switch(this.charAt(1)){
				case '/' : 
					/**
					 *	Parse navigator
					**/
					var parts = this.split('~');
					
					var path = parts[0].split('/');
					var index = path.shift() + path.shift();
					
					/**
					 *	Construct message for workflow
					**/
					message[ 'service' ] = index;
					for(var j in path){
						//path[j] = unescape(path[j]);
						message[j] = path[j];
					}
					
					if(parts[1] || false){
						var req = parts[1].split('/');
						for(var i = 1, len=req.length; i<len; i+=2){
							//req[i + 1] = unescape(req[i + 1]);
							message[req[i]] = req[i + 1];
						}
					}

					break;
				
				default :
					$navigator = this
					$navigator = $navigator.replace(/_/g, '#');
					$navigator = $navigator.replace(/\./g, '=');
					/**
					 *	Parse navigator
					 **/
					var req = $navigator.split(':');
					var index = req[0];
					
					/**
					 *	Construct message for workflow
					**/
					message[ 'service' ] = index;
					for(var i=1, len=req.length; i<len; i++){
						var param = (req[i]).split('=');
						var arg = param[1];
						arg = arg.replace(/~/g, '=');
						//arg = unescape(arg);
						message[param[0]] = arg;
					}					
					break;

			}
			
			/**
			 *	Run the workflow and return the valid value
			**/
			memory = message.run( memory );
			return memory[ 'valid' ];
		}
	} );
	
	var registry = {};
	
	/**
	 *	Save a reference string
	**/
	Object.defineProperty( String.prototype, "save", { 
		value: function( val ){
			registry[ this ] = val;
		}
	} );
	
	/**
	 *	Get value of a reference
	**/
	Object.defineProperty( String.prototype, "get", { 
		value: function(){
			return registry[ this ] || undefined;
		}
	} );
	
	/**
	 *	Delete a reference string
	**/
	Object.defineProperty( String.prototype, "del", { 
		value: function(){
			registry[ this ] = 0;
		}
	} );
	
} )( window );