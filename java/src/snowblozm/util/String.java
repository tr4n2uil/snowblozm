package snowblozm.util;/** *	@class String *	@desc Utility functions for manipulating strings * *	@author Vibhaj Rajan <vibhaj8@gmail.com> ***/public class String {		/**	 *	@method ucfirst	 *	@desc captalizes first letter of the string	 *	 *	@param word string		 *	**/	public static java.lang.String ucfirst(java.lang.String word){		return word.substring(0, 1).toUpperCase() + word.substring(1);	}	}