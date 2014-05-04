<?php
namespace Core\Libraries\Upload;
/**
* File upload class.
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Upload 
{
    /**
    * @var array alowed file types
    */
    private $allowedTypes = ['png', 'jpg', 'jpeg', 'bmp'];

    /**
    * @var string path of upload dir
    */
    private $uploadPath = PUBLIC_PATH;

    /**
    * @var int maximum alowed size
    */
    private $maxSize = 1024;

    /**
    * @var int maximum alowed width 
    */
    private $maxWidth = 0;

    /**
    * @var int maximum alowed height
    */
    private $maxHeight = 0;

    /**
    * @var string error message
    */
    private $error = '';

    /**
    * @var string file extension
    */
    private $fileExt = '';

    /**
    * @var string file name override
    */
    private $fileOverride = '';

    /**
    * @var bool remove spaces from name
    */
    private $removeSpaces = true;
    
    /*
    * @var string default field name
    */
    private $field = 'file';

    /**
     * Class constructor
     * @param array
     */
    public function __construct($params = []) 
    {
        // Check for valid uploaded file
        if (isset($_FILES[$this->field])) {
            // Load params from passed array
            foreach ($params as $key => $val) {
                $this->$key = $val;
            }
            // Get uploaded file parameters
            $this->fileName = $this->prepFilename($_FILES[$this->field]['name']);
            $this->fileSize = $_FILES[$this->field]['size'];
            $this->fileTemp = $_FILES[$this->field]['tmp_name'];
            $this->fileExt  = $this->getExtension($this->fileName);
        } else {
            throw new \InvalidArgumentException('File upload error!');
        }
    }

    /*
    * Execute file upload
    */
    public function execute()
    {
        // Check for upload errors
        if ($_FILES[$this->field]["error"] > 0) {
            $this->error =  "Error: ".$_FILES[$this->field]["error"]."";
            return false;
        }

        // Is the file type allowed to be uploaded?
        if (!$this->isAllowedFiletype()) {
            $this->error = 'upload_invalid_filetype';
            return false;
        }

        // Check upload path
        if (!$this->validateUploadPath()) {
            return false;
        }

        // Convert the file size to kilobytes
        $this->fileSize = round($this->fileSize/1024, 2);
        // Check file size
        if($this->fileSize > ($this->maxSize)) {
            $this->error = 'file_size_not_alowed';
            return false;
        }

        // Sanitize the file name for security
        $this->fileName = $this->cleanFileName($this->fileName);


        // Remove white spaces in the name
        if ($this->removeSpaces == true) {
            $this->fileName = preg_replace("/\s+/", "_", $this->fileName);
        }

        /*
        * Move the file to the final destination
        * To deal with different server configurations
        * try to use copy() first. If that fails
        * move_uploaded_file() is used.
        */
        if (!@copy($this->fileTemp, $this->uploadPath.'/'.$this->fileName)) {
            if (!@move_uploaded_file($this->fileTemp, $this->uploadPath.'/'.$this->fileName)) {
                $this->error = 'unable_to_copy_file';
                return false;
            }
        }
        // Try to change mod of uploaded file
        chmod($this->uploadPath.'/'.$this->fileName, 0755);
        // If everything is fine return true
        return true;
    }

    /**
    * Verify that the filetype is allowed
    * @return bool
    */
    public function isAllowedFiletype()
    {
        if ($this->allowedTypes == '*') {
            return true;
        }

        if (count($this->allowedTypes) == 0 || !is_array($this->allowedTypes)) {
            $this->error = 'upload_no_file_types';
            return false;
        }

        $ext = strtolower(ltrim($this->fileExt, '.'));

        if (!in_array($ext, $this->allowedTypes)) {
            return false;
        }

        // Images get some additional checks
        $imageTypes = ['gif', 'jpg', 'jpeg', 'png', 'jpe'];

        if (in_array($ext, $imageTypes)) {
            if (getimagesize($this->fileTemp) === false) {
                return false;
            }
        }
        return true;
    }

    /**
    * Validate upload path
    * @return bool
    */
    public function validateUploadPath()
    {
        if ($this->uploadPath == '') {
            $this->error = 'upload_no_filepath';
            return false;
        }

        if (function_exists('realpath') && @realpath($this->uploadPath) !== false) {
            $this->uploadPath = str_replace("\\", "/", realpath($this->uploadPath));
        }

        if (!@is_dir($this->uploadPath)) {
            $this->error = 'upload_no_filepath';
            return false;
        }

        $this->uploadPath = preg_replace("/(.+?)\/*$/", "\\1/", $this->uploadPath);
        return true;
    }

    /**
    * Prep Filename
    * Prevents possible script execution from Apache's handling of files multiple extensions
    * http://httpd.apache.org/docs/1.3/mod/mod_mime.html#multipleext
    * @param string
    * @return string
    */
    private function prepFilename($filename)
    {
        if (strpos($filename, '.') === FALSE || $this->allowedTypes == '*') {
            return $filename;
        }
        $parts    = explode('.', $filename);
        $ext      = array_pop($parts);
        $filename = array_shift($parts);
        foreach ($parts as $part) {
            if (!in_array(strtolower($part), $this->allowedTypes) && $this->mimes_types(strtolower($part)) === FALSE) {
                $filename .= '.'.$part.'_';
            } else {
                $filename .= '.'.$part;
            }
        }
        $filename .= '.'.$ext;
        return $filename;
    }

    /**
    * Get extension of file
    * @param string
    * @return string
    */
    public function getExtension($filename)
    {
        $x = explode('.', $filename);
        return '.'.end($x);
    }

    /**
    * Clean the file name for security
    * @param string
    * @return string
    */
    public function cleanFileName($filename)
    {
        $bad = ["<!--",
                "-->",
                "'",
                "<",
                ">",
                '"',
                '&',
                '$',
                '=',
                ';',
                '?',
                '/',
                "%20",
                "%22",
                "%3c",  // <
                "%253c",// <
                "%3e",  // >
                "%0e",  // >
                "%28",  // (
                "%29",  // )
                "%2528",// (
                "%26",  // &
                "%24",  // $
                "%3f",  // ?
                "%3b",  // ;
                "%3d"   // =
                ];
        $filename = str_replace($bad, '', $filename);
        return stripslashes($filename);
    }

    /**
    * Helper function used to delete file.
    * @param string
    * @return bool
    */
    public function deleteFile($path)
    {
        return unlink($path);
    }

    /**
    * @return string
    */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
    * @return int
    */
    public function getFileSize()
    {
        return $this->fileSize;
    }

    /**
    * @return string
    */
    public function getError()
    {
        return $this->error;
    }
}