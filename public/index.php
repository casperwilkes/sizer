<?php

/**
 * This is the main and upload page for the project.
 * 
 * @author Casper Wilkes <casper@casperwilkes.net>
 */

// Require loader //
require '../boot.php';

// Set up vars //
// Logger object //
$log = new Logger();
// error collector //
$error = array();
// temp messages //
$m = array();
// stringified errors //
$messages = '';
// template vars //
$view = 'form';
$page_title = 'Upload an Image';

// Don't process until form is submitted //
if (isset($_POST['submit'])) {
    // Allowable image types //
    $types = array('image/jpeg', 'image/gif', 'image/png');
    // Filter the $_POST //
    $post = filter_input_array(INPUT_POST, $_POST);
    // Get the $_FILE //
    $file = $_FILES['file_upload'];
    // Get and cast the height and width //
    $height = (int) $post['height'];
    $width = (int) $post['width'];

    // Check file errors //
    if ($_FILES['file_upload']['error'] == 4) {
        $error[] = 'Must upload an image.';
    }
    if ($_FILES['file_upload']['error'] == 1) {
        $error[] = 'Image too large, please select a different one.';
    }
    // Check height and width to make sure both are set //
    if (($height == 0) && ($width == 0)) {
        $error[] = 'Both height and width cannot be zero';
    }
    // Make sure file type is allowable //
    if (!in_array($_FILES['file_upload']['type'], $types)) {
        $error[] = "Image must either be a jpeg, gif, or png.";
    }

    // Check that there were no errors //
    if (empty($error)) {
        // Initialize Image object and pass file //
        $image = new Image($file);
        // Set new dimensions //
        $image->setDimensions($height, $width);
        // Check file moved successfully //
        if ($image->moveFile()) {
            // Put the image object in the session //
            $_SESSION['image'] = $image;
            // Redirect //
            header('Location: generator.php');
        } else {
            // There was an error moving the file //
            $error[] = 'There was a problem with your submission. Please try again.';
            // Write to log //
            $log->genLog($error[0], 'Move file');
        }
    } else {
        // Output errors to log //
        $log->genLog('errors: ' . implode(', ', $error), 'Upload Error');
        // stringify and send to template //
        foreach ($error as $err) {
            $m[] = $err;
        }
        $messages = '<ul><li>' . implode('</li><li>', $m) . '</li></ul>';
    }
}

// Setup the template //
require(VIEWS . DS . 'base.php');
