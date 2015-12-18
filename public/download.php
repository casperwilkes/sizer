<?php

/**
 * This is a simple downloader to grab and return images 
 * 
 * @author Casper Wilkes <casper@casperwilkes.net>
 */
// Make sure get is set //
if (isset($_GET['image'])) {
    // Get the loader //
    require '../boot.php';

    // Grab name //
    $name = $_GET['image'];

    $file = SITE_ROOT . DS . 'public' . DS . 'assets' . DS . 'images' . DS . 'resized' . DS . $name;

    // Make sure we have a file //
    if (!file_exists($file)) {
        // File doesn't exist, output error
        die('File not found');
    } else {
        // Check extension for content type //
        $ext = basename($file);
        if ($ext == 'jpg') {
            $type = 'jpeg';
        } else {
            $type = $ext;
        }

        // Set headers //
        header("Pragma: no-cache");
        header("Content-Length: " . filesize($file));
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename={$name}");
        header("Content-Type: image/{$type}");
        header("Content-Transfer-Encoding: binary");

        // Read the file from disk //
        readfile($file);
    }
} else {
    // Redirect //
    header("Location: index.php");
    exit;
}