<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/vendor/components/jquery/jquery.js"></script>
</head>
<body class="container">
<?php

use classes\App;

?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Test</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                <li><a href="#">Link</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>
            <?php if (App::getInstance()->isGuest()) : ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/user/signin">Sign In</a></li>
                    <li>
                        <a href="/user/login">Login</a>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/user/logout">Logout</a></li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>
<?= $content ?>
</body>
</html>