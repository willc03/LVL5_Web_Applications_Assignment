<!DOCTYPE html>
<html>
    <head>
        <title>Furness Golf Club - <?php echo $title; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> <!-- Enables responsive features -->
        <link rel="icon" href="assets/favicon.ico"> <!-- A custom icon will be used for this web application -->
        <link rel="stylesheet" type="text/css" href="assets/style.css"> <!-- Custom-written CSS will be used, as it is easier to customise -->
    </head>
    <body>
        <div id="header">
            <nav id="nav" class="container">
                <a id="nav" class="title" href="/">Furness Golf Club</a>
                <ul id="nav" class="buttons">
                    <?php foreach ($nav_pages as $nav_button) { ?>
                        <li>
                            <a id="nav" class="button" href="<?php echo $nav_button["url"]; ?>"><?php echo $nav_button["btn_title"]; ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
        <div id="main">
        