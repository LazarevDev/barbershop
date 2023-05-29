<?php 

// проверка на куки 

if(!empty($_COOKIE['login']) OR !empty($_COOKIE['password'])){

    $loginCookie = $_COOKIE['login'];
    $passwordCookie = $_COOKIE['password'];

    $queryStaffCookie = mysqli_query($db, "SELECT * FROM `staff` WHERE `login` = '$loginCookie' and `password` = '$passwordCookie'");
    $resultStaffCookie = mysqli_fetch_array($queryStaffCookie);   
    
    if(!$resultStaffCookie){
        header('Location: login.php');
    }
}else{
    header('Location: login.php');
}
?>

<link rel="stylesheet" href="css/components.css">
<link rel="stylesheet" href="css/menu.css">

<div class="menu">
    <ul class="menuUl">
        <div class="menuLogo">
            <div class="menuLogoContainer">
                <div class="menuLogoImg">
                    <img src="" alt="">
                </div>

                <div class="menuLogoText">
                    <h2><?php echo $resultStaffCookie['name']; ?></h2>
                    <a href="/index.php">Вернутся на сайт</a>
                </div>
            </div>
        </div>
        <li><a href="statistics.php">Статистика</a></li>
        <li><a href="services.php">Услуги</a></li>
        <li><a href="staff.php">Сотрудники</a></li>
        <li><a href="work_schedule.php">График работы персонала</a></li>
        <li><a href="clients.php">Клиенты</a></li>
        <li><a href="appointment.php">Записи</a></li>
        <li><a href="products.php">Товары</a></li>
        <li><a href="review.php">Отзывы</a></li>
        <li><a href="">Выход</a></li>
    </ul>
</div>