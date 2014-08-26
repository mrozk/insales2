<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @var array       $config      Global blog configuration
 * @var string      $title       Page Title
 * @var string      $author      Material author
 * @var string      $description Meta description tag content
 * @var string      $keywords    Meta keywords tag content
 * @var string|View $content     Page content
 *
 * @author     Novichkov Sergey(Radik) <novichkovsergey@yandex.ru>
 * @copyright  Copyrights (c) 2012 Novichkov Sergey
 */
?><!DOCTYPE html>
<html>
<head>
    <title><?php /* echo isset($title) ? $title :  Arr::path($config, 'blog.name')  */ ?></title>

    <!-- Base URL -->
    <base href="<?php echo URL::base(true, false) ?>">

    <!-- System -->
    <meta name="author" content="<?php /* echo isset($author) ? $author : Arr::path($config, 'blog.author') */?>" />
    <meta name="description" content="<?php /* echo isset($description) ? $description : Arr::path($config, 'blog.description') */?>" />
    <meta name="keywords" content="<?php /* echo isset($keywords) ? $keywords : Arr::path($config, 'blog.keywords') */?>" />

    <!-- Twitter Bootstrap -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?php echo $base_url; ?>html/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" media="all" />
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>
<!-- Template Content  -->

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="javascript:void(0);">Панель настроек Insales - DDelivery</a>
        </div>

    </div>
</div>

<div class="container" style="margin-top: 60px;">
    <!-- Example row of columns -->
    <div class="row">
        <div class="col-md-10">
            <?php if( !empty( $system_msg['success'] ) )
                  {
                ?>
            <div class="alert alert-success">
                <strong><?php echo $system_msg['success']; ?></strong>
            </div>
            <?php
                  }
            ?>
            <?php if( !empty( $system_msg['error'] ) )
            {
                ?>
                <div class="alert alert-danger">
                    <strong><?php echo $system_msg['error']; ?></strong>
                </div>
            <?php
            }
            ?>
        <?php echo isset($content) ? $content : '' ?>
        </div>
    </div>
    <hr>
    <footer>
        <p>&copy; Company 2014</p>
    </footer>
</div> <!-- /container -->
<!-- JS Code -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>html/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>