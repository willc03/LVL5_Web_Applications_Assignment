<!DOCTYPE html>
<html>
    <head>
        <title>CodeIgniter</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div id="header">
            <h2 id="company_title">Furness Golf Club</h2>
            <nav id="navigation">
                <?php foreach ($nav_pages as $nav_button) { ?>
                    <a href="<?php echo $nav_button["url"]; ?>"><?php echo $nav_button["btn_title"]; ?></a>
                <?php } ?>
            </nav>
        </div>