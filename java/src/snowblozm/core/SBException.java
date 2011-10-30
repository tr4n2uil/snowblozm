package snowblozm.core;

/**
 *	@interface SBException
 *	@desc Snowblozm Block exception interface
 *
 *	@reference http://www.json.org/javadoc/org/json/JSONException.html
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
 **/
public class SBException extends Exception {
	
	private static final long serialVersionUID = 0;
	private Throwable cause;

    /**
	 *	@method constructor
	 *	@desc Constructs a SBException with an explanatory message
	 *
	 *	@param message - Detail about the reason for the exception
	 *
	**/
    public SBException(String message) {
        super(message);
    }

    public SBException(Throwable cause) {
        super(cause.getMessage());
        this.cause = cause;
    }

    public Throwable getCause() {
        return this.cause;
    }
	
}

