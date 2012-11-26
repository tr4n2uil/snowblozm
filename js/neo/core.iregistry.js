/**
 *	@type iRegistry
 *	@desc intelliRegistry: universal reference container
 *
 *	@extend String
 *
**/
( function( window, undefined ){
	
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