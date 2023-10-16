<!DOCTYPE html>
<html lang="fr">

<head>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Mota">
    <meta name="author" content="http://localhost:81/mota/">
    <link rel="shortcut icon" href="/wp-content/themes/mota/assets/images/logo.png">


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
                        'container' => '',
                        'theme_location' => 'primary',
                        'item_wrap' => '<ul id="" class="navbar-nav flex-column text-sm-center text-md-left">%3$s</ul>'
                    )
                );
                ?>
            </div>
        </nav>
     
    </header>


  