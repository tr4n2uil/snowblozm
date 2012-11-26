/**
 *	@method inherit
 *	@desc manages classical inheritance over prototypical inheritance in javascript
 *
**/
Function.prototype.inherit = function( $parent ){ 
	//Normal Inheritance 
	if ( $parent.constructor == Function ){ 
		this.prototype = new $parent;
		this.prototype.constructor = this;
		this.prototype.parent = $parent.prototype;
	}
	//Pure Virtual Inheritance 
	else{ 
		this.prototype = $parent;
		this.prototype.constructor = this;
		this.prototype.parent = $parent;
	} 
	
	return this;
}
