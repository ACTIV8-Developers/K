<?php
namespace Core\Libraries\Upload;

/**
* File upload class.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Upload 
{
    /**
    * Allowed file types
    * @var array
    */
    private $allowedTypes = ['png', 'jpg', 'jpeg', 'bmp'];

    /**
    * Path of upload dir
    * @var string
    */
    private $uploadPath = PUBLIC_PATH;

    /**
    * Maximum allowed upload size
    * @var int
    */
    private $maxSize = 1024;

    /**
    * Maximum allowed image width
    * @var int
    */
    private $maxWidth = 0;

    /**
    *  Maximum allowed image height
    * @var int
    */
    private $maxHeight = 0;

    /**
    * Error message
    * @var string
    */
    private $error = '';

    /**
    * File extension
    * @var string
    */
    private $fileExt = '';

    /**
    * File name override
    * @var string
    */
    private $nameOverride = false;

    /**
    * File name override
    * @var string
    */
    private $overwrite = false;

    /**
    * Remove spaces from name
    * @var bool
    */
    private $removeSpaces = true;
    
    /**
    * Default field name
    * @var string
    */
    private $field = 'file';

    /**
    * List of PHP upload errors
    * @var array
    */
    private $uploadError = [
        'There is no error, the file uploaded with success.',
        'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
        'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
        'The uploaded file was only partially uploaded.',
        'No file was uploaded.',
        '',
        'Missing a temporary folder.',
        'Failed to write file to disk.',
        'A PHP extension stopped the file upload.'
    ];

    /**
     * Class constructor
     * @param array
     * @throws \InvalidArgumentException
     */
    public function __construct($params = []) 
    {
        // Load params from passed array
        foreach ($params as $key => $val) {
            $this->$key = $val;
        }
    }

    /*
    * Execute file upload
    */
    public function execute()
    {
        // Check for valid uploaded file
        if (isset($_FILES[$this->field])) {
            // Get uploaded file parameters
            $this->fileName = $this->prepFilename($_FILES[$this->field]['name']);
            $this->fileSize = $_FILES[$this->field]['size'];
            $this->fileTemp = $_FILES[$this->field]['tmp_name'];
            $this->fileExt  = $this->getExtension($this->fileName);
        } else {
            return false;
        }

        // Check for upload errors
        if ($_FILES[$this->field]["error"] > 0) {
            $this->error = $this->uploadError[$_FILES[$this->field]["error"]];
            return false;
        }

        // Is the file type allowed to be uploaded?
        if (!$this->isAllowedFiletype()) {
            $this->error = 'File type not allowed!';
            return false;
        }

        // Check upload path
        if (!$this->validateUploadPath()) {
            return false;
        }

        // Convert the file size to kilobytes
        $this->fileSize = round($this->fileSize/1024, 2);
        // Check file size
        if ($this->fileSize > ($this->maxSize)) {
            $this->error = 'File size not allowed!';
            return false;
        }

        // Set new file name if overide name is true
        if ($this->nameOverride) {
            $this->fileName = $this->nameOverride.$this->fileExt;
        }

        // Sanitize the file name for security
        $this->fileName = $this->cleanFileName($this->fileName);

        // Remove white spaces in the name
        if ($this->removeSpaces == true) {
            $this->fileName = preg_replace("/\s+/", "_", $this->fileName);
        }

        if (!$this->overwrite) {
            $i = 1;
            $temp = $this->fileName;
            while (file_exists($this->uploadPath.'/'.$temp)) {
                $temp = strstr($this->fileName, $this->fileExt, true).'('.$i++.')'.$this->fileExt;
            }
            $this->fileName = $temp;
        }

        /*
        * Move the file to the final destination
        * To deal with different server configurations
        * try to use copy() first. If that fails
        * move_uploaded_file() is used.
        */
        if (!@copy($this->fileTemp, $this->uploadPath.'/'.$this->fileName)) {
            if (!@move_uploaded_file($this->fileTemp, $this->uploadPath.'/'.$this->fileName)) {
                $this->error = 'Unable to copy file to filesystem!';
                return false;
            }
        }
        // Try to change mod of uploaded file
        chmod($this->uploadPath.'/'.$this->fileName, 0755);
        // If everything is fine return true
        return true;
    }

    /**
    * Verify that the file type is allowed
    * @return bool
    */
    public function isAllowedFiletype()
    {
        if ($this->allowedTypes == '*') {
            return true;
        }

        if (count($this->allowedTypes) == 0 || !is_array($this->allowedTypes)) {
            $this->error = 'No list of allowed file types set!';
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
            $this->error = 'No upload path set!';
            return false;
        }

        if (function_exists('realpath') && @realpath($this->uploadPath) !== false) {
            $this->uploadPath = str_replace("\\", "/", realpath($this->uploadPath));
        }

        if (!@is_dir($this->uploadPath)) {
            $this->error = 'Invalid upload path!';
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
    private function getExtension($filename)
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
    * @return string
    */
    public function getFileExtension()
    {
        return $this->fileExt;
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

    /**
    * @return string
    */
    public function getField()
    {
        return $this->field;
    }

    /**
    * @return array
    */
    public function getAllowedTypes()
    {
        return $this->allowedTypes;
    }

    /**
    * @return string
    */
    public function getUploadPath()
    {
        return $this->uploadPath;
    }

    /**
    * @param array
    */
    public function setAllowedTypes($allowedTypes)
    {
        $this->allowedTypes = $allowedTypes;
    }

    /**
    * @param string
    */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
    * @param string
    */
    public function setUploadPath($uploadPath)
    {
        $this->uploadPath = $uploadPath;
    }

    /**
    * @param string
    */
    public function setFileNameOverride($nameOverride)
    {
        $this->nameOverride = $nameOverride;
    }
}