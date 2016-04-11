<?php

class Utils_Uploader 
{
	private $allowedExtensions = array();
	private $sizeLimit = 41943040;
	private $file;

	public function __construct(array $allowedExtensions = array(), $sizeLimit = 41943040){        
		$allowedExtensions = array_map("strtolower", $allowedExtensions);

		$this->allowedExtensions = $allowedExtensions;        
		$this->sizeLimit = $sizeLimit;

//		$this->checkServerSettings();       

		if (isset($_GET['qqfile'])) {
			$this->file = new Utils_Uploadedxhr();
		} elseif (isset($_FILES['qqfile'])) {
			$this->file = new Utils_Uploadedform();
		} else {
			$this->file = false; 
		}
	}

	private function checkServerSettings(){        
		$postSize = $this->toBytes(ini_get('post_max_size'));
		$uploadSize = $this->toBytes(ini_get('upload_max_filesize'));        
                if ($postSize > $this->sizeLimit || $uploadSize > $this->sizeLimit){
			$size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';             
			die("{'error':'increase post_max_size and upload_max_filesize to $size'}");    
		}        
	}

	private function toBytes($str){
		$val = trim($str);
		$last = strtolower($str[strlen($str)-1]);
		switch($last) {
		case 'g': $val *= 1024;
		case 'm': $val *= 1024;
		case 'k': $val *= 1024;        
		}
		return $val;
	}

	/**
	 * Returns array('success'=>true) or array('error'=>'error message')
	 */
	public function handleUpload($uploadDirectory, $replaceOldFile = FALSE){
           	if (!is_writable($uploadDirectory)){
			return array('error' => "Server error. Upload directory isn't writable.");
		}

		if (!$this->file){
			return array('error' => 'No files were uploaded.');
		}

		$size = $this->file->getSize();

		if ($size == 0) {
			return array('error' => 'File is empty');
		}

		if ( $size > $this->sizeLimit) {
			return array('error' => 'File is too large');
		}

		$pathinfo = pathinfo($this->file->getName());
		$filename = $pathinfo['filename'];
		//$filename = md5(uniqid());
		$ext = $pathinfo['extension'];

		if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
			$these = implode(', ', $this->allowedExtensions);
			return array('error' =>'Allowable formats: '. strtoupper($these) . '. Size limit: 3 mb.');
		}

		if(!$replaceOldFile){
			/// don't overwrite previous files that were uploaded
			while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
				$filename .= rand(10, 99);
			}
		}
                
		if ($this->file->save($uploadDirectory . $filename . '.' . $ext)){
                        //echo $uploadDirectory . $filename . '.' . $ext;
			return array('success'=>true, 'filename' => $filename, 'ext' => $ext, 'full_filename' => $filename.'.'.$ext,'size' => $size);
		} else {
			return array('error'=> 'Could not save uploaded file.' .
				'The upload was cancelled, or server error encountered');
		}

	}  
        
        public function handleUploadRename($uploadDirectory, $newfile, $replaceOldFile = FALSE){
           	if (!is_writable($uploadDirectory)){
			return array('error' => "Server error. Upload directory isn't writable.");
		}

		if (!$this->file){
			return array('error' => 'No files were uploaded.');
		}

		$size = $this->file->getSize();

		if ($size == 0) {
			return array('error' => 'File is empty');
		}

		if ( $size > $this->sizeLimit) {
			return array('error' => 'File is too large');
		}

		 $pathinfo = pathinfo($this->file->getName());
		 $filename = $pathinfo['filename'];
                 //$filename = time() . "_" . $filename;
                 $filename = $newfile;
		//$filename = md5(uniqid());
		$ext = $pathinfo['extension'];
		if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
			$these = implode(', ', $this->allowedExtensions);
			return array('error' =>'Allowable formats: '. strtoupper($these) . '. Size limit: 3 mb.');
		}

		if(!$replaceOldFile){
			/// don't overwrite previous files that were uploaded
			while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
				$filename .= rand(10, 99);
			}
		}
                
		if ($this->file->save($uploadDirectory . $filename . '.' . $ext)){
                        //echo $uploadDirectory . $filename . '.' . $ext;
			return array('success'=>true, 'filename' => $filename, 'ext' => $ext, 'full_filename' => $filename.'.'.$ext, 'size' => $size);
		} else {
			return array('error'=> 'Could not save uploaded file.' .
				'The upload was cancelled, or server error encountered');
		}

	} 
}