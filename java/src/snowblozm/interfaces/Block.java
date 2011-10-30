package snowblozm.interfaces;

import java.util.Map;
import java.util.Iterator;
import java.io.Writer;

import snowblozm.core.SBException;

/**
 *	@interface Block
 *	@desc Flexible object interface
 *
 *	@reference http://www.json.org/javadoc/org/json/JSONObject.html
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
 **/
public interface Block {
	
	/**
	 *	@method accumulate
	 *	@desc Accumulate values under a key
	 *
	 *	@param key - A key string
	 *	@param value - An object to be accumulated under the key
	 *	
	 *	@return Block this
	 *
	**/
	public Block accumulate(String key, Object value) throws SBException;
	
	/**
	 *	@method append
	 *	@desc Append values to the array under a key
	 *
	 *	@param key - A key string
	 *	@param value - An object to be appended under the key
	 *	
	 *	@return Block this
	 *
	**/
	public Block append(String key, Object value) throws SBException;
	
	/**
	 *	@method get
	 *	@desc Get the value object associated with a key
	 *
	 *	@param key - A key string
	 *	
	 *	@return Object The object associated with the key
	 *
	**/
	public Object get(String key) throws SBException;
	
	/**
	 *	@method get<Type>
	 *	@desc Get the value associated with a key
	 *
	 *	@param key - A key string
	 *	
	 *	@return <Type>
	 *
	**/
	public boolean getBoolean(String key) throws SBException;
	public int getInt(String key) throws SBException;
	public long getLong(String key) throws SBException;
	public double getDouble(String key) throws SBException;
	public String getString(String key) throws SBException;
	public Sequence getSequence(String key) throws SBException;
	public Block getBlock(String key) throws SBException;
	
	/**
	 *	@method has
	 *	@desc Determine if the JSONObject contains a specific key.
	 *
	 *	@param key - A key string
	 *	
	 *	@return boolean 
	 *
	**/
	public boolean has(String key);
	
	/**
	 *	@method isNull
	 *	@desc Determine if the value associated with the key is null or if there is no value
	 *
	 *	@param key - A key string
	 *	
	 *	@return boolean 
	 *
	**/
	public boolean isNull(String key);
	
	/**
	 *	@method keys
	 *	@desc Get an enumeration of the keys of the Block
	 *	
	 *	@return boolean 
	 *
	**/
	public Iterator keys();
	
	/**
	 *	@method length
	 *	@desc Get the number of keys stored in the Block
	 *	
	 *	@return int 
	 *
	**/
	public int length();
	
	/**
	 *	@method names
	 *	@desc Produce a Sequence containing the names of the elements of this Block
	 *	
	 *	@return sequence 
	 *
	**/
	public Sequence names();
	
	/**
	 *	@method put
	 *	@desc Put a key/value pair into the block replacing old value for key if any
	 *
	 *	@param key - A key string
	 *	@param value - Value to be inserted
	 *	
	 *	@return block this 
	 *
	**/
	public Block put(String key, Object value) throws SBException;
	public Block put(String key, boolean value) throws SBException;
	public Block put(String key, int value) throws SBException;
	public Block put(String key, long value) throws SBException;
	public Block put(String key, double value) throws SBException;
	public Block put(String key, Map<String, Object> value) throws SBException;
	
	/**
	 *	@method putOnce
	 *	@desc Put a key/value pair in the JSONObject, but only if the key and the value are both non-null, and only if there is not already a member with that name
	 *
	 *	@param key - A key string
	 *	@param value - Value to be inserted
	 *	
	 *	@return block this 
	 *
	**/
	public Block putOnce(String key, Object value) throws SBException;
	
	/**
	 *	@method remove
	 *	@desc Remove a name and its value, if present
	 *
	 *	@param key - A key string
	 *	
	 *	@return object removed value
	 *
	**/
	public Object remove(String key);
	
	/**
	 *	@method toSequence
	 *	@desc Produce a Sequence containing the values of the members of this Block
	 *
	 *	@param names - A Sequence containing list of keys
	 *	
	 *	@return sequence values array
	 *
	**/
	public Sequence toSequence(Sequence names) throws SBException;
	
	/**
	 *	@method toString
	 *	@desc Make a serialized text of this Block
	 *	
	 *	@return string serialized text
	 *
	**/
	public String toString();
	public String toString(int indentFactor) throws SBException;

	/**
	 *	@method write
	 *	@desc Write a serialized text of this Block to output writer
	 *	
	 *	@return writer 
	 *
	**/
	public Writer write(Writer writer) throws SBException;
	
}
