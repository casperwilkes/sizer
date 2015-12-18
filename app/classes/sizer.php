<?php

/**
 * This class wraps the ImageMagick object and resizes the image
 * 
 * @author Casper Wilkes <casper@casperwilkes.net>
 */
class Sizer {

    /**
     * Logger object
     * @var Logger
     */
    private $log;

    /**
     * Image object
     * @var Image
     */
    private $image;

    public function __construct(Image $image) {
        $this->log = new Logger();
        $this->image = $image;
    }

    /**
     * Resizes an image image
     * @return boolean
     */
    public function resize() {
        try {
            // Create new Image object //
            $im = new Imagick($this->image->get('image_path'));

            // Resize the image //
            $im->scaleimage($this->image->get('height'), $this->image->get('width'));

            // Grab the output from writing the image to disk //
            $return = $im->writeimage($this->image->get('resized_path'));

            // Clean up memory //
            $im->clear();
            $im->destroy();

            // $return only returns true if image is written //
            return ($return) ? true : false;
        } catch (Exception $e) {
            $this->log->exceptionLog($e, __METHOD__);
        }
    }

}
