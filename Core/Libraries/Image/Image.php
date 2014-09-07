<?php
namespace Core\Libraries\Image;

/**
* Image manipulation class.
*
* @author Milos Kajnaco <miloskajnaco@warpmail.net>
*/
 class Image
 {
 	/**
 	* @var int
 	*/
 	protected $width = 0;

 	/**
 	* @var int
 	*/
 	protected $height = 0;

 	/**
 	* Possible values exact, portrait, landscape, auto, crop.
 	* @var string
 	*/
 	protected $option = 'exact';

 	/**
 	* @var int
 	*/
 	protected $imageQuality = "100";
 	
 	/**
 	* @var string
 	*/
 	protected $image = null;

 	/**
 	* @var string
 	*/
 	protected $imageResized = null;

 	/**
 	* @var string
 	*/
 	protected $library = 'gd';

 	/**
 	* @var string
 	*/
 	protected $filepath = '';

 	/**
	* Class constructor.
	* @param array
 	*/
 	public function __construct(array $params)
 	{
        foreach ($params as $key => $val) {
            if (isset($this->$key)) {
                $this->$key = $val;
            }
        }
 	}

 	/**
 	* Wrapper function to call one of concrete resize
 	* functions depending of avaliable image library
 	* (array params are height, width, option, keepOriginal)
 	* @param array
 	* @return bool
 	* @throws InvalidArgumentException
 	*/
 	public function resize($params = [])
 	{
 		// Check input
 		if ($params['height'] <= 0 || $params['width'] <= 0
 			|| !isset($params['option'])) {
 			return false;
 		}

 		switch ($this->library) {
 			case 'gd':
 				if (extension_loaded('gd')) {
 					return $this->resizeGD($params);
	 				break;
 				}
			default:
				throw new \InvalidArgumentException('Invalid extension type.');		
 		}
 	}

 	/**
 	* Resize function based on GD image library
 	* @param array
 	* @return bool
 	*/
 	protected function resizeGD($params = [])
 	{	 			
 		if (!is_file($this->filepath)) {
 			return false;
 		}

	    // Get extension.
	    $extension = strtolower(strrchr($this->filepath, '.'));

	    // Open image.
	    switch ($extension) {
	        case '.jpg':
	        case '.jpeg':
	            $this->image = @imagecreatefromjpeg($this->filepath);
	            break;
	        case '.gif':
	            $this->image = @imagecreatefromgif($this->filepath);
	            break;
	        case '.png':
	            $this->image = @imagecreatefrompng($this->filepath);
	            break;
	        default:
	            $this->image = false;
	            break;
	    }

	    // If opening failed return false.
	    if (!$this->image) {
	    	return false;
	    }
	    
	    // Get image original dimensions.
        $this->width  = imagesx($this->image);
        $this->height = imagesy($this->image);

	    // Get optimal width and height - based on option.
	    $optionArray = $this->getDimensions($params['width'], $params['height'], strtolower($params['option']));
	 
	    $optimalWidth  = $optionArray['optimalWidth'];
	    $optimalHeight = $optionArray['optimalHeight'];
	 
	    // Resample - create image canvas of x, y size.
	    $this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
	    imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, 
	    	$this->width, $this->height);

	    // If option is 'crop', then crop too.
	    if ($params['option'] == 'crop') {
	        $this->crop($optimalWidth, $optimalHeight, $params['width'], $params['height']);
	    }

	    return true;
 	}

 	/**
 	* Calculate optimal new dimensions.
 	* @param int
 	* @param int
 	* @param string
 	* @return array (optimalWidth and optimalHeight)
 	*/
 	protected function getDimensions($newWidth, $newHeight, $option)
	{
	   switch ($option) {
	        case 'exact':
	            $optimalWidth = $newWidth;
	            $optimalHeight= $newHeight;
	            break;
	        case 'portrait':
	            $optimalWidth = $this->getSizeByFixedHeight($newHeight);
	            $optimalHeight= $newHeight;
	            break;
	        case 'landscape':
	            $optimalWidth = $newWidth;
	            $optimalHeight= $this->getSizeByFixedWidth($newWidth);
	            break;
	        case 'auto':
	            $optionArray = $this->getSizeByAuto($newWidth, $newHeight);
	            $optimalWidth = $optionArray['optimalWidth'];
	            $optimalHeight = $optionArray['optimalHeight'];
	            break;
	        case 'crop':
	            $optionArray = $this->getOptimalCrop($newWidth, $newHeight);
	            $optimalWidth = $optionArray['optimalWidth'];
	            $optimalHeight = $optionArray['optimalHeight'];
	            break;
	    }
	    return ['optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight];
	}

	/**
	* Helper function to calculate dimensions.
	* @param int
	*/
	protected function getSizeByFixedHeight($newHeight)
	{
	    $ratio = $this->width / $this->height;
	    $newWidth = $newHeight * $ratio;
	    return $newWidth;
	}
	
	/**
	* Helper function to calculate dimensions.
	* @param int
	*/ 
	protected function getSizeByFixedWidth($newWidth)
	{
	    $ratio = $this->height / $this->width;
	    $newHeight = $newWidth * $ratio;
	    return $newHeight;
	}
	
	/**
	* Helper function to calculate dimensions.
	* @param int
	* @param int
	* @return array (optimalWidth and optimalHeight)
	*/
	protected function getSizeByAuto($newWidth, $newHeight)
	{
	    if ($this->height < $this->width)
	    // Image to be resized is wider (landscape).
	    {
	        $optimalWidth = $newWidth;
	        $optimalHeight= $this->getSizeByFixedWidth($newWidth);
	    }
	    elseif ($this->height > $this->width)
	    // Image to be resized is taller (portrait).
	    {
	        $optimalWidth = $this->getSizeByFixedHeight($newHeight);
	        $optimalHeight= $newHeight;
	    }
	    else
	    // Image to be resizerd is a square.
	    {
	        if ($newHeight < $newWidth) {
	            $optimalWidth = $newWidth;
	            $optimalHeight= $this->getSizeByFixedWidth($newWidth);
	        } else if ($newHeight > $newWidth) {
	            $optimalWidth = $this->getSizeByFixedHeight($newHeight);
	            $optimalHeight= $newHeight;
	        } else {
	            // Sqaure being resized to a square.
	            $optimalWidth = $newWidth;
	            $optimalHeight= $newHeight;
	        }
	    }
	    return ['optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight];
	}
 
 	/**
	* Helper function to calculate dimensions.
	* @param int
	* @param int
	* @return array (optimalWidth and optimalHeight)
	*/
	protected function getOptimalCrop($newWidth, $newHeight)
	{
	 
	    $heightRatio = $this->height / $newHeight;
	    $widthRatio  = $this->width / $newWidth;
	 
	    if ($heightRatio < $widthRatio) {
	        $optimalRatio = $heightRatio;
	    } else {
	        $optimalRatio = $widthRatio;
	    }
	 
	    $optimalHeight = $this->height / $optimalRatio;
	    $optimalWidth  = $this->width  / $optimalRatio;
	    return ['optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight];
	}

	protected function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight)
	{
	    // Find center - this will be used for the crop.
	    $cropStartX = ($optimalWidth / 2) - ($newWidth / 2);
	    $cropStartY = ($optimalHeight / 2) - ($newHeight / 2);
	 
	    $crop = $this->imageResized;
	 
	    // Now crop from center to exact requested size.
	    $this->imageResized = imagecreatetruecolor($newWidth , $newHeight);
	    imagecopyresampled($this->imageResized, $crop , 0, 0, $cropStartX, $cropStartY, 
	    	$newWidth, $newHeight , $newWidth, $newHeight);
	}

	/**
	* Save previously resized image, if new name is same as old
	* original image will be overwriten.
	* @param string
	* @param int
	* @param bool
	*/
	public function saveImage($savePath)
	{
		if ($this->imageResized === null) {
			return false;
		}

	    // Get extension.
	    $extension = strrchr($savePath, '.');
	    $extension = strtolower($extension);
	 
	    switch ($extension) {
	        case '.jpg':
	        case '.jpeg':
	            if (imagetypes() & IMG_JPG) {
	                imagejpeg($this->imageResized, $savePath, $this->imageQuality);
	            }
	            break;
	        case '.gif':
	            if (imagetypes() & IMG_GIF) {
	                imagegif($this->imageResized, $savePath);
	            }
	            break;
	        case '.png':
	            // Scale quality from 0-100 to 0-9.
	            $scaleQuality = round(($this->imageQuality / 100) * 9);
	            // Invert quality setting as 0 is best, not 9.
	            $invertScaleQuality = 9 - $scaleQuality;
	            if (imagetypes() & IMG_PNG) {
	                imagepng($this->imageResized, $savePath, $invertScaleQuality);
	            }
	            break;
	        default:
	            return false;
	            break;
	    }
	    imagedestroy($this->imageResized);
	    return true;
	}

	/**
	* Delete originaly passed image.
	* @return bool
	*/
	public function deleteOriginal()
	{
		if (is_file($this->filename)) {
			return @unlink($this->filename);
		}
		return false;
	}

	/**
	* @param int
	*/
	public function setQuality($q)
	{
		$this->quality = $q;
	}
 }