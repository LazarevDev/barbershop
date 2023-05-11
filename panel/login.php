<?php
require_once('../require/db.php');

if(isset($_POST['submit'])){
    $login = $_POST['login'];
    $password = md5($_POST['password']);

    $queryStaff = mysqli_query($db, "SELECT * FROM `staff` WHERE `login` = '$login' and `password` = '$password'");
    $resultStaff = mysqli_fetch_array($queryStaff);

    if(!empty($resultStaff)){
        setcookie('login', $login);
        setcookie('password', $password);

        header('Location: statistics.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/login.css">    
    <title>Document</title>
</head>
<body>
    <section class="login">
        <div class="container">
            <div class="center">
                <form action="" method="post" class="formLogin">
                    <h2>Вход</h2>
                    <input type="text" name="login" placeholder="Введите логин"><br>
                    <input type="password" name="password" placeholder="Введите пароль"><br>
                    <input type="submit" class="submitLogin" name="submit" value="Войти">
                </form>
            </div>
        </div>
    </section>
</body>
</html>