<!DOCTYPE html>
<html>
    <head>
        <title><?php echo 'Furness Golf Club - ' . esc($title); ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> <!-- Enables responsive features -->
        <link rel="icon" href="assets/favicon.ico"> <!-- A custom icon will be used for this web application -->
        <link rel="stylesheet" type="text/css" href="/assets/style.css"> <!-- Custom-written CSS will be used, as it is easier to customise -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="http://maps.googleapis.com/maps/api/js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    </head>
    <body>
        <div id="footerWrap">
            <div id="header">
                <img src="<?php echo site_url('/assets/golf-ball.png'); ?>" style="height: 75px; width: 75px">
                <a id="title" href="/">Furness Golf Club</a>
                <nav id="navigation">
                    <ul>
                        <?php foreach ($nav_pages as $nav_button) { ?>
                            <li>
                                <a id="nav" class="button" href="<?php echo $nav_button["url"]; ?>"><?php echo $nav_button["btn_title"]; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
            <div id="main" class="flex_container">
        