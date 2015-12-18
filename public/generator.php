<?php

/**
 * This page grabs the Image object out of the $_SESSION and gives it to the generator
 * 
 * @author Casper Wilkes <casper@casperwilkes.net>
 */

require '../boot.php';

// Set up the view and title //
$view = 'generator';
$page_title = 'Generated';

// Get the Image object //
$image = $_SESSION['image'];

// Instatiate the sizer //
$generator = new Sizer($image);

// Use the name to display the image and pass it to the download button //
$name = $image->get('name');

// Resize the image //
if ($generator->resize()) {
    // Resize successful, output image and download button //
    $messages = '<p><button value="Download"><a href="download.php?image=' . $name . '" title="Download Image">Download Image</a></button></p>';
    $output = '<img src="' . 'assets/images/resized/' . $name . '"/>';
} else {
    // Something went wrong
    $output = '';
    $messages = '<p>Could not generate image at this time. Check logs and try again.</p>';
}

// Set up template //
require(VIEWS . DS . 'base.php');
