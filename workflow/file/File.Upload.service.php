<?php 
require_once(SBSERVICE);

/**
 *	@class FileUploadService
 *	@desc Uploads file to given destination
 *
 *	@param key string File key [message]
 *	@param maxsize long int Maximum size [message|memory] optional default false
 *	@param path string Path to save file [message|memory]
 *	@param name string Filename [message|memory] optional default name received
 *
 *	@return filename string Filename received [memory]
 *	@return size long int File size in bytes [memory]
 *	@return mime string File MIME if available [memory] optional default ''
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class FileUploadService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$key = $message['key'];
		$path = isset($message['path']) ? $message['path'] : $memory['path'];
		$file = $_FILES[$key];
		
		switch($file['error']){
			case UPLOAD_ERR_OK : 
				break;
			case UPLOAD_ERR_INI_SIZE : 
				$memory['valid'] = false;
				$memory['msg'] = "File is larger than maximum possible to be uploaded";
				$memory['status'] = 503;
				$memory['details'] = 'Error UPLOAD_ERR_INI_SIZE @file.upload.service';
				return $memory;
			case UPLOAD_ERR_PARTIAL :
				$memory['valid'] = false;
				$memory['msg'] = "File was partially uploaded";
				$memory['status'] = 503;
				$memory['details'] = 'Error UPLOAD_ERR_PARTIAL @file.upload.service';
				return $memory;
			case UPLOAD_ERR_NO_FILE :
				$memory['valid'] = false;
				$memory['msg'] = "No file was uploaded";
				$memory['status'] = 503;
				$memory['details'] = 'Error UPLOAD_ERR_NO_FILE @file.upload.service';
				return $memory;
			default: 
				$memory['valid'] = false;
				$memory['msg'] = "Internal Error";
				$memory['status'] = 503;
				$memory['details'] = 'Error default @file.upload.service';
				return $memory;
		}
		
		$maxsize = isset($message['maxsize']) ? $message['maxsize'] : (isset($memory['maxsize']) ? $memory['maxsize'] : false)
		
		if($maxsize){
			if($file['size'] > $message['maxsize']){
				$memory['valid'] = false;
				$memory['msg'] = "File is larger than maximum allowed";
				$memory['status'] = 503;
				$memory['details'] = 'Error MAX_SIZE_LIMIT_REACHED @file.upload.service';
				return $memory;
			}
		}
		
		$memory['filename'] = basename($file['name']);
		$memory['size'] = $file['size'];
		
		$filename = ((isset($message['name']) ? $message['name'] : (isset($memory['name']) ? $memory['name'] :$memory['filename'])));
		
		if(!move_uploaded_file($file['tmp_name'], $path.$filename)){
			$memory['valid'] = false;
			$memory['msg'] = "Internal Error";
			$memory['status'] = 503;
			$memory['details'] = 'Error moving file : '.$file['tmp_name'].' @file.upload.service';
			return $memory;
		}
		
		$memory['valid'] = true;
		$memory['msg'] = 'File Uploaded Successfully';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
}

?>