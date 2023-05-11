<?php 
require_once('../require/db.php');


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


if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $login = $_POST['login'];
    $specialization = $_POST['specialization'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $description = $_POST['description'];
    $salary = $_POST['salary'];
    $perecent = $_POST['perecent'];
    $photo = $_POST['photo'];
    $password = md5($_POST['password']);


            
    $queryAddStaff = "INSERT INTO `staff` (`name`, `login`, `specialization`, `telephone`, `email`, `description`,`salary`, `perecent`, `password`) VALUES 
    ('$name', '$login', '$specialization', '$telephone', '$email', '$description', '$salary', '$perecent', '$password')";
    
    $resultAddStaff = mysqli_query($db, $queryAddStaff) or die(mysqli_error($db));


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/statistics.css">
    <link rel="stylesheet" href="css/staff.css">
    <title>Document</title>
</head>
<body>
    <main>
        <?php require_once('include/menu.php'); ?>

        <section class="statistic">
            <div class="sectionTitle">
                <h2>Добавить сотрудника</h2>
            </div>

            <div class="content">
                <form action="" method="post">
                    <input type="text" name="name" placeholder="Введите имя">
                    <input type="text" name="login" placeholder="Введите логин">

                    <select name="specialization" id="">
                        <option value="0">Младший барбер</option>
                        <option value="1">Старший барбер</option>
                        <option value="2">Администратор</option>
                    </select>

                    <input type="text" name="telephone" placeholder="Введите телефон">
                    <input type="email" name="email" placeholder="Введите email">
                    <textarea name="description" placeholder="Введите описание"></textarea>
                    <input type="text" name="salary" placeholder="Оклад">
                    <input type="text" name="perecent" placeholder="Процент с услуг">
                    <input type="file" name="photo">
                    <input type="password" name="password" placeholder="Введите пароль">
                    <input type="submit" name="submit" class="submit">
                </form>
            </div>
        </section>
    </main>
</body>
</html>