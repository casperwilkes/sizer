<?php

/**
 * This is a basic logger for collecting exceptions and general logs.
 * 
 * @author Casper Wilkes <casper@casperwilkes.net>
 */
class Logger {

    /**
     * Sets the time error occured. 
     * @var Datetime
     */
    private $time;

    /**
     * Sets the current file path.
     * @var string
     */
    private $log_dir;

    /**
     * Path where log sits
     * @var string
     */
    private $log_path;

    /**
     * Catches all of the errors and creates a string indexed array.
     * @var array
     */
    private $error_array = array();

    /**
     * Class Constructor.
     * @param string $log Name of the logfile 
     */
    public function __construct() {
        $this->setProps();
    }

    /**
     * Creates an exception specific log.
     * @param \Exception $e The exception that occured
     * @param string $method Method where exception occured
     */
    public function exceptionLog(\Exception $e, $method) {
        foreach ($e as $k => $v) {
            $this->error_array[$k] = $v;
        }
        // Add extra class information //
        $this->error_array['Message'] = preg_replace('/\s\s+/', ' ', $e->getMessage());
        $this->error_array['Trace'] = preg_replace('/\n/', ' ', $e->getTraceAsString());
        $this->error_array['Method'] = $method;
        $this->error_array['Time'] = $this->time;

        $this->logError();
    }

    /**
     * Creates a generalized error log.
     * @param mixed $message String or Array message
     * @param method $method Area or method where error occured
     */
    public function genlog($message, $method) {
        // Build error array //
        if (is_array($message)) {
            $time_method = array('Time' => $this->time, 'Method' => $method);
            $this->error_array = array_merge($time_method, $message);
        } else {
            $this->error_array = array(
                'Time' => $this->time,
                'Method' => $method,
                'Message' => $message
            );
        }

        // Output the error log //
        $this->logError();
    }

    /**
     * Set the time property.  
     */
    private function setTime() {
        $this->time = strftime("%Y-%m-%d %H:%M:%S", time());
    }

    /**
     * Logs the errors to the specified log file. 
     */
    private function logError() {
        // Test if file is new //
        $new = file_exists($this->log_path) ? FALSE : TRUE;

        // Create logs dir if it doesn't already exist //
        if (!is_dir($this->log_dir)) {
            mkdir($this->log_dir, 0755);
        }

        // Write message to file //
        $handle = fopen($this->log_path, 'a');
        if ($handle) {
            foreach ($this->error_array as $key => $value) {
                fwrite($handle, $key . ': ' . $value . PHP_EOL);
            }
            fwrite($handle, '-------------------' . PHP_EOL);
            fclose($handle);
            if ($new) {
                chmod($this->log_path, 0755);
            }
        }
    }

    /**
     * Sets the properties of the class
     */
    private function setProps() {
        $name = 'general.txt';
        $this->setTime();
        $this->log_dir = SITE_ROOT . DS . 'logs';
        $this->log_path = $this->log_dir . DS . $name;
    }

}
