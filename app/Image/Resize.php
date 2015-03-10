<?php
namespace App\Image;

class Resize
{
    private $constrainProportions = true;
    
    private $oldWidth = 0;
    
    private $newWidth = 0;
    
    private $oldHeight = 0;
    
    private $newHeight = 0;
    
    private $rawImage;
    
    /**
     * @brief _____
     * @param type $name _____
     * @retval type _____
     */
    public function source($source)
    {
        $this->rawImage = \imagecreatefromstring(
            base64_decode(
                str_replace(' ', '+', $source)
            )
        );
        $this->oldWidth = \imagesx($this->rawImage);
        $this->oldHeight = \imagesy($this->rawImage);
        
        return $this;
    }//end source()
    
    /**
     * @brief _____
     * @param type $name _____
     * @retval type _____
     */
    public function width($width)
    {
        $this->newWidth = $width;
        if ($this->constrainProportions) {
            $this->newHeight = \floor(($this->oldHeight * $this->newWidth) / $this->oldWidth);
        }//end if
        
        return $this;
    }//end width()
    
    /**
     * @brief _____
     * @param type $name _____
     * @retval type _____
     */
    public function height($height)
    {
        $this->newHeight = $height;
        if ($this->constrainProportions) {
            $this->newHeight = \floor(($this->oldWidth * $this->newHeight) / $this->oldHeight);
        }//end if
        
        return $this;
    }//end height()
    
    /**
     * @brief _____
     * @param type $name _____
     * @retval type _____
     */
    public function constrainProportions($constrain)
    {
        $this->constrainProportions = $constrain;
        
        return $this;
    }//end constrainProportions()
    
    /**
     * @brief _____
     * @param type $name _____
     * @retval type _____
     */
    public function getSizedImage()
    {
        $newImage = \imagecreatetruecolor($this->newWidth, $this->newHeight);
        \imagecopyresampled(
            $newImage,
            $this->rawImage,
            0,
            0,
            0,
            0,
            $this->newWidth,
            $this->newHeight,
            $this->oldWidth,
            $this->oldHeight
        );
        ob_start();
        \imagejpeg($newImage);
        return base64_encode(ob_get_clean());
    }//end getSizedImage()
}//end class Resize

//end file: ./app/Image/Resize.php
