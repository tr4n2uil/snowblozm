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
		$file = $memory['file'];
		$size = $memory['size'];
		$asname = $memory['filename'];
		$mime = $memory['mime'];
		
		if (file_exists($file)) {
			set_time_limit(0);
			header('Content-Description: File Transfer');
			header("Content-Type: $mime");
			header("Content-Disposition: attachment; filename=\"$asname\"");
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . $size);
			ob_clean();
			flush();
			readfile($file);
		}
		else {
			$memory['valid'] = false;
				$memory['msg'] = "File Not Found";
				$memory['status'] = 504;
				$memory['details'] = 'Error file not found : '.$file.' @file.upload.service';
				return $memory;
		}
		
		$memory['valid'] = true;
		$memory['msg'] = 'File Downloaded Successfully';
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