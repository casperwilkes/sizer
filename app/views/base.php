<?php
/**
 * This is the base template
 * 
 * @author Casper Wilkes <casper@casperwilkes.net>
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Re-Sizer | <?= $page_title; ?></title>
        <style type="text/css">
            label, 
            button, 
            p {
                font-size: 1.2em;
            }
            button a {
                text-decoration: none;
                color: #000;
            }
            #image img{
                border-style: groove;
            }
        </style>
        <base href="http://localhost/sizer/public/index.php" />
    </head>
    <body>
        <header>
            <h1>Re-sizer</h1>
            <h2><?= $page_title; ?></h2>
        </header>
        <?= $messages; ?>
        <main role="main">
            <?php include(VIEWS . DS . $view . '.php'); ?>
        </main>
    </body>
</html>

