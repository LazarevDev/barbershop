<?php 
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/normalize.css">

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
            <a href="" class="headerLogo">
                <div class="headerLogoImg">
                    <img src="img/components/header/logo.png" alt="">
                </div>

                <div class="headerLogoTitle">
                    <h2>Барбершоп</h2>
                    <p>Липецкая область</p>
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
                    <li><a href="#service" class="headerLink">Продукция</a></li>
                    <li><a href="#footer" class="headerLink">Услуги</a></li>

                    <div class="headerBtnContainerMobile">
                        <a href="#" class="headerBtnBlog">Блог</a>
                        <a href="#" class="headerBtnContacts">Контакты</a>
                    </div>
                </ul>
            </nav>

            <div class="headerBtnContainer">
                <a href="#" class="headerBtnBlog">Войти</a>
                <!-- <a href="#" class="headerBtnContacts">Контакты</a> -->
            </div>
        </div>
    </div>
</header>