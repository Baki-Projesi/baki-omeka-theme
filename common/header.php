<!DOCTYPE html>
<html lang="<?php echo get_html_lang(); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if ( $description = option('description')): ?>
        <meta name="description" content="<?php echo $description; ?>" />
    <?php endif; ?>

    <!-- Will build the page <title> -->
    <?php
        if (isset($title)) { $titleParts[] = strip_formatting($title); }
        $titleParts[] = option('site_title');
    ?>
    <title><?php echo implode(' &middot; ', $titleParts); ?></title>
    <?php echo auto_discovery_link_tags(); ?>

    <!-- Will fire plugins that need to include their own files in <head> -->
    <?php fire_plugin_hook('public_head', array('view'=>$this)); ?>


    <!-- Need to add custom and third-party CSS files? Include them here -->
    <?php 
        queue_css_file('lib/bootstrap.min');
        queue_css_file('nr');
        queue_css_file('nav-v4');
        queue_css_file('style');
        echo head_css();
    ?>

    <!-- Need more JavaScript files? Include them here -->
    <?php 
        queue_js_file('lib/bootstrap.min');
      //  queue_js_file('globals');
        queue_js_url('https://ajax.googleapis.com/ajax/libs/webfont/1.5.18/webfont.js');
        queue_js_file('fonts');
        queue_js_file('hide_show_transcript');
        queue_js_file('globals');
     //   queue_js_file('dropdown-fix');
       // queue_js_file('streaming_player_dock');
        echo head_js();
    ?>
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<?php echo body_tag(array('id' => @$bodyid, 'class' => @$bodyclass)); ?>
    <?php fire_plugin_hook('public_body', array('view'=>$this)); ?>
    <header>

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#primary-navigation"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                    <a id="nr-logo" class="navbar-brand" href="/">
                        <img alt="New Roots Navigation Logo" src="<?php echo img("nr-boxed.png") ?>" />
                    </a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="primary-navigation"> <!-- top-navbar -->
                    <?php echo public_nav_main_bootstrap(); ?>
                    <div class="navbar-right-group">
                        <a href="http://twitter.com/NewRootsVoces">
                            <img src="<?php echo img("twitter-icon.png") ?>" id="twitter-icon" alt="Twitter Icon" />
                        </a>
                        <!-- <form class="navbar-form navbar-right" role="search" action="<?php echo public_url(''); ?>search"> -->
                        <div class="navbar-form navbar-right">
                            <?php echo search_form(array('show_advanced' => false)); ?>
                        </div>
                       <!--  </form> -->
                    </div>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
            <?php fire_plugin_hook('public_header', array('view'=>$this)); ?>
        </nav>
    </header>        
    <div id="content" class="container-fluid primary-container">
        <?php fire_plugin_hook('public_content_top', array('view'=>$this)); ?>
