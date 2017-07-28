<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/include/connection.php");
if($_SESSION['session_username']){header("Location: http://gallery.24myfree.ru/");}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="HandheldFriendly" content="True">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<script type="text/javascript" src="/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/js/main.min.js"></script>
<script type="text/javascript" src="/uikit/js/uikit.min.js"></script>
<script type="text/javascript" src="/uikit/js/core/core.min.js"></script>
<script src="/uikit/js/components/slider.js"></script>
<link rel="stylesheet" href="/uikit/css/uikit.min.css" type="text/css">
<link rel="stylesheet" href="/uikit/css/components/slider.min.css" type="text/css">
<link rel="stylesheet" href="/css/main.min.css" type="text/css">
<link rel="stylesheet" href="/css/fawesome.css" type="text/css">

<?php
if($_GET['do']=='register'){echo '<script type="text/javascript" src="/js/jquery.validate.min.js"></script><script src="https://www.google.com/recaptcha/api.js"></script>';}
if($_GET['do']=='auth'){echo '<script type="text/javascript" src="/js/jquery.validate.min.js"></script>';}
?>
<title>
<?php
if($_GET['do']=='register'){echo 'Регистрация посетителя » ';}
if($_GET['do']=='auth'){echo 'Авторизация посетителя » ';}
?>
gallery.24myfree.ru
</title>
</head>
<?php
//if($_GET['message']){require_once($_SERVER["DOCUMENT_ROOT"]."/message.php");}
if($_GET['do']=='register'){require_once("register.html");}
elseif($_GET['do']=='auth'){require_once("auth.html");}
elseif($_GET['do']=='social'){require_once("social.php");}
elseif($_GET['do']=='top'){require_once("top.html");}
elseif($_GET['do']=='old'){require_once("old.html");}
else{require_once("main.html");}
?>
<a id="Go_Top" style="display: block;"><img alt="up" src="/img/ups.svg"></a>
<div class="container-bottom">
<div class="text-bottom left">
<?php 
if($_GET['do']=='register'){echo '<a href="?do=auth">Авторизация</a>';}
elseif($_GET['do']=='auth'){echo '<a href="?do=register">Регистрация</a>';}
else{if($_SESSION['session_username']){echo '<a href="?do=profile">Профиль</a>';}else{echo '<a href="?do=auth">Вход/Регистрация</a>';}}
?>
</div>
<div class="soc_links">
<a href="https://oauth.vk.com/authorize?client_id=5449879&amp;redirect_uri=http://gallery.24myfree.ru/login/?do=social%26provider%3Dvk&amp;scope=email&amp;response_type=code" class="soc_vk"></a>
<a href="https://accounts.google.com/o/oauth2/auth?redirect_uri=http://gallery.24myfree.ru/login/?do=social%26provider%3Dgoogle&amp;response_type=code&amp;client_id=415167080739-a0j01p0ej3plh4jma986kr6de46b2tl7.apps.googleusercontent.com&amp;scope=https://www.googleapis.com/auth/userinfo.email%20https://www.googleapis.com/auth/userinfo.profile%20https://www.googleapis.com/auth/plus.login" class="soc_google"></a>
<a href="https://oauth.yandex.ru/authorize?response_type=code&amp;redirect_uri=http://gallery.24myfree.ru/login/?do=social%26provider%3Dyandex&amp;client_id=1f3b88c2878a4695a1ef60989fdf1b14&amp;display=popup" class="soc_yandex"></a>
<a href="https://connect.mail.ru/oauth/authorize?client_id=744082&amp;client_id=2f9f6ed6811dda3a0d055bfa86c23dc9&amp;response_type=code&amp;redirect_uri=http://gallery.24myfree.ru/login/?do=social%26provider%3Dmail" class="soc_mail"></a>
</div>
<div class="text-bottom right"><a href="/">Главная</a></div>
</div>
</div></div>
</body>
</html>