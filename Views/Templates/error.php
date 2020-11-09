<?php

use Projet\Database\Setting;
use Projet\Model\App;
use Projet\Model\FileHelper;
use Projet\Model\Session;

$page = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$session = Session::getInstance();
?>
<!doctype html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no"/>
    <title><?= App::getTitle(); ?></title>
    <link href="<?= FileHelper::url('assets/plugins/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= FileHelper::url('assets/plugins/fontawesome/css/font-awesome.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= FileHelper::url('assets/plugins/line-icons/simple-line-icons.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= FileHelper::url('assets/css/modern.min.css') ?>" rel="stylesheet" type="text/css">
</head>
<body class="page-login login-alt">

    <main class="page-content" style="background: #f7f8f8">
        <?php
        echo $content;
        ?>
    </main>
</body>
</html>