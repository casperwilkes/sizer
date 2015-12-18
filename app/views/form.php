<?php
/**
 * This template is displayed for the main page
 * 
 * @author Casper Wilkes <casper@casperwilkes.net>
 */
?>
<div id="form">
    <form action="index.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
        <label for="image">Image:</label>
        <input type="file" name="file_upload" id="image" />
        <br />
        <label for="width">Width:</label>
        <input type="text" name="width" id="width" size="10" />
        <br />
        <label for="height">Height</label>
        <input type="text" name="height" id="height" size="10" />
        <br />
        <br>
        <input type="submit" name="submit" value="[D]Motivate!" />
    </form>
</div>