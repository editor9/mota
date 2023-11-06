<!DOCTYPE html>
<html lang="fr">

<head>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Mota">
    <meta name="author" content="http://localhost:81/mota/">
    <link rel="icon" href="/mota/wp-content/plugins/wp-migrate-db/frontend/template/public/favicon.ico"
        type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Space+Mono:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <?php
    wp_head();
    ?>
</head>

<body>

    <header class="header text-center row">

        <div class="col">
            <?php
            if (function_exists('the_custom_logo')) {
                the_custom_logo();
            }
            ?>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light col">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navigation" class="collapse navbar-collapse">

                <?php
                wp_nav_menu(
                    array(
                        'menu' => 'primary',
                        'container' => 'ul',
                        // Add the container element
                        'theme_location' => 'primary',
                        'items_wrap' => '<ul id="%1$s" class="navbar-nav ml-auto">%3$s</ul>' // Modify the items_wrap to use ml-auto for right alignment
                    )
                );
                ?>
            </div>
        </nav>

    </header>