<?php 
require_once('require/db.php');
require_once('require/cookie-client-check.php');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/components.css">

    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/production.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parallax/3.1.0/parallax.min.js"></script>
    <title>Document</title>
</head>
<body>
<header class="header">
    <div class="container">
        <div class="headerBody">
            <a href="../index.php" class="headerLogo">
                <div class="headerLogoTitle">
                    <img src="../img/components/header/logo.png" alt="">
                    <p>123456, Г. Липецк, московская улица, дом 789</p>
                </div>
            </a>
            
            <div class="headerBurger">
                <span></span>
                <span></span>
            </div>

            <nav class="headerMenu">
                <ul class="headerList">
                    <li><a href="#home" class="headerLink">Главная</a></li>
                    <li><a href="#cases" class="headerLink">О нас</a></li>
                    <li><a href="#service" class="headerLink">Услуги</a></li>
                    <li><a href="#footer" class="headerLink">Товары</a></li>

                    <div class="headerBtnContainerMobile">
                       <?php 
                       if(!empty($cookieTelephone)){?>
                            <a href="basket.php" class="headerBtnMobile"><img src="../img/components/header/bask.png" alt=""> Корзина</a>
                            <a href="profile.php" class="headerBtnMobile"><img src="../img/components/header/user.png" alt=""> Профиль</a> 
                       <?php }else{ ?>
                            <a href="login.php" class="headerBtnMobile"><img src="../img/components/header/user.png" alt=""> Войти</a> 
                       <?php } ?>
                    </div>
                </ul>
            </nav>

            <div class="headerBtnContainer">
                <?php if(!empty($cookieTelephone)){?>
                    <a href="basket.php" class="headerBtnImg"><img src="../img/components/header/bask.png" alt=""> Корзина</a>
                    <a href="profile.php" class="headerBtnImg"><img src="../img/components/header/user.png" alt=""> Профиль</a>
                <?php }else{ ?>
                    <a href="login.php" class="headerBtnImg"><img src="../img/components/header/user.png" alt=""> Войти</a> 
                <?php } ?>
            </div>
        </div>
    </div>
</header>

<script src="../js/menu.js"></script>