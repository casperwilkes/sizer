<?php

/**
 * This class contains all functionality needed to modify and contain image information.
 * 
 * @author Casper Wilkes <casper@casperwilkes.net>
 */
class Image {

    /**
     * The logger object
     * @var Logger
     */
    private $log;

    /**
     * Contains all of the associated image information
     * @example [name, type, size, image_path, resized_path, height, width]
     * @var array
     */
    private $image_info = array();

    public function __construct($file) {
        $this->setlog();
        $this->imageInfo($file);
        $this->imagePath();
    }

    /**
     * Moves the uploaded file from the temp directory to the permanent one
     * @return boolean
     */
    public function moveFile() {
        try {
            if (move_uploaded_file($this->image_info['tmp_name'], $this->image_info['image_path'])) {
                $this->log->genLog('Successfully moved file: ' . $this->image_info['name'], __METHOD__);
                // We no longer need these because image has been moved and we don't want anyone requesting them //
                unset($this->image_info['tmp_name']);
                unset($this->image_info['error']);
                return true;
            } else {
                $this->log->genLog('Could not move file: ' . $this->image_info['name'], __METHOD__);
                return false;
            }
        } catch (Exception $e) {
            $this->log->exceptionLog($e, __METHOD__);
        }
    }

    /**
     * Sets the dimensions for the new image
     * @param int $height
     * @param int $width
     */
    public function setDimensions($height, $width) {
        $this->image_info['height'] = $height;
        $this->image_info['width'] = $width;
    }

    /**
     * Gets requested image information
     * @param string $value
     * @return mixed
     */
    public function get($value) {
        if (array_key_exists($value, $this->image_info)) {
            return $this->image_info[$value];
        }
        return null;
    }

    /**
     * Sets the image and resize paths
     */
    private function imagePath() {
        $this->image_info['image_path'] = SITE_ROOT . DS . 'public' . DS . 'assets' . DS . 'images' . DS . $this->image_info['name'];
        $this->image_info['resized_path'] = SITE_ROOT . DS . 'public' . DS . 'assets' . DS . 'images' . DS . 'resized' . DS . $this->image_info['name'];
    }

    /**
     * sets up the logger
     */
    private function setLog() {
        $this->log = new Logger();
    }

    /**
     * Sets the file info into a useable array
     * @example [name, type, tmp_name, error, size]
     * @param array $array $_FILES array
     */
    private function imageInfo(array $array) {
        foreach ($array as $k => $v) {
            $this->image_info[$k] = $v;
        }
    }

}
