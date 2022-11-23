<!DOCTYPE html>
<html>
    <head>
        <title>Furness Golf Club - <?php echo $title; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="/assets/favicon.ico">
        <!-- Use the Bootstrap Content Delivery Network (CDN) to download the CSS files. -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    </head>
    <body>
        <div id="header">
            <nav class="navbar navbar-expand-lg bg-light"> <!-- Bootstrap framework has been used to created navigation bar -->
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">Furness Golf Club</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle Navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <?php foreach ($nav_pages as $nav_button) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $nav_button["url"]; ?>"><?php echo $nav_button["btn_title"]; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>