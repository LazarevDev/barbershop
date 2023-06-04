<?php 
// проверка на куки 
require_once('require-panel/cookie.php');



$queryMenuPhoto = mysqli_query($db, "SELECT * FROM `staff` WHERE `login` = '$loginCookie'");
$menuPhoto = mysqli_fetch_array($queryMenuPhoto);
?>

<link rel="stylesheet" href="css/components.css">
<link rel="stylesheet" href="css/menu.css">

<div class="menu">
    <ul class="menuUl">
        <div class="menuLogo">
            <div class="menuLogoContainer">
                <div class="menuLogoImg">
                    <img src="../img/admin-photo/<?php echo $menuPhoto['login']."/".$menuPhoto['photo']; ?>" alt="">
                </div>

                <div class="menuLogoText">
                    <h2><?php echo $resultCookie['name']; ?></h2>
                    <a href="/index.php">Вернутся на сайт</a>
                </div>
            </div>
        </div>
        <li><a href="services.php">Услуги</a></li>
        <li><a href="staff.php">Сотрудники</a></li>
        <li><a href="work_schedule.php">График работы персонала</a></li>
        <li><a href="clients.php">Клиенты</a></li>
        <li><a href="appointment.php">Записи</a></li>
        <li><a href="products.php">Товары</a></li>
        <li><a href="accounting.php">Учет товаров</a></li>
        <li><a href="review.php">Отзывы</a></li>
        <li><a href="logout.php">Выход</a></li>
    </ul>
</div>