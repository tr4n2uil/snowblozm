<?php 
require_once(SBSERVICE);

/**
 *	@class FileDownloadService
 *	@desc Reads and echoes file at specified destination
 *
 *	@param file string File (full path + name) [memory]
 *	@param size long int File size in bytes [memory]
 *	@param mime string File MIME type [message] optional default 'application/force-download'
 *	@param filename string Filename [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class FileDownloadService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('file', 'filename', 'size'),
			'optional' => array('mime' => 'application/force-download')
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$filename = $memory['file'];
		$size = $memory['size'];
		$asname = $memory['filename'];
		$mime = $memory['mime'];
		
		if(!is_file($filename)){
			$memory['valid'] = false;
				$memory['msg'] = "File Not Found";
				$memory['status'] = 504;
				$memory['details'] = 'Error file not found : '.$filename.' @file.upload.service';
				return $memory;
		}
		
		set_time_limit(0);
		
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Type: $mime");
		header("Content-Disposition: attachment; filename=\"$asname\"");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: " . $size);
		
		$file = @fopen($filename,"rb");
		if ($file) {
			while(!feof($file)) {
				print(fread($file, 1024*8));
				flush();
				if (connection_status()!=0) {
					@fclose($file);
					die();
				}
			}
		@fclose($file);
		}
		
		$memory['valid'] = true;
		$memory['msg'] = 'File Uploaded Successfully';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array();
	}
	
}

?>