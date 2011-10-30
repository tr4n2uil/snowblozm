package snowblozm.interfaces;

import java.util.Map;
import java.io.Writer;

import snowblozm.core.SBException;

/**
 *	@interface Sequence
 *	@desc Flexible array interface
 *
 *	@reference http://www.json.org/javadoc/org/json/JSONArray.html
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
 **/
public interface Sequence {
	
	/**
	 *	@method get
	 *	@desc Get the object value associated with an index
	 *
	 *	@param index - The index must be between 0 and length() - 1
	 *	
	 *	@return Object The object associated with the key
	 *
	**/
	public Object get(int index) throws SBException;
	
	/**
	 *	@method get<Type>
	 *	@desc Get the value associated with the index
	 *
	 *	@param index - The index must be between 0 and length() - 1
	 *	
	 *	@return <Type>
	 *
	**/
	public boolean getBoolean(int index) throws SBException;
	public int getInt(int index) throws SBException;
	public long getLong(int index) throws SBException;
	public double getDouble(int index) throws SBException;
	public String getString(int index) throws SBException;
	public Sequence getSequence(int index) throws SBException;
	public Block getBlock(int index) throws SBException;
	
	/**
	 *	@method isNull
	 *	@desc Determine if the value associated with the index is null or if there is no value
	 *
	 *	@param index - The index must be between 0 and length() - 1
	 *	
	 *	@return boolean 
	 *
	**/
	public boolean isNull(int index);
	
	/**
	 *	@method join
	 *	@desc Get an enumeration of the keys of the Sequence
	 *	
	 *	@param separator - A string that will be inserted between the elements
	 *
	 *	@return string concatenated result 
	 *
	**/
	public String join(String separator) throws SBException;
	
	/**
	 *	@method length
	 *	@desc Get the number of keys stored in the Sequence
	 *	
	 *	@return int 
	 *
	**/
	public int length();
	
	/**
	 *	@method put
	 *	@desc Put a value into the sequence replacing old value for key if any
	 *
	 *	@param value - Value to be inserted
	 *	
	 *	@return sequence this 
	 *
	**/
	public Sequence put(Object value);
	public Sequence put(boolean value);
	public Sequence put(int value);
	public Sequence put(long value);
	public Sequence put(double value) throws SBException;
	public Sequence put(Map<String, Object> value);
	
	/**
	 *	@method remove
	 *	@desc Remove a name and its value, if present
	 *
	 *	@param index - The index must be between 0 and length() - 1
	 *	
	 *	@return object removed value
	 *
	**/
	public Object remove(int index);
	
	/**
	 *	@method toSequence
	 *	@desc Produce a Block by combining a Sequence of names with the values of this Sequence
	 *
	 *	@param names - A Sequence containing list of keys
	 *	
	 *	@return block object
	 *
	**/
	public Block toBlock(Sequence names) throws SBException;
	
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
