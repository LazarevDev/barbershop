<?php 
require_once('require/db.php');

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $date = date('Y-m-d H:i:s');

    $queryClientCheck = mysqli_query($db, "SELECT * FROM `clients` WHERE `telephone` = '$telephone'");
    $resultClientCheck = mysqli_fetch_array($queryClientCheck);

    if(!$resultClientCheck){
        $addClient = mysqli_query($db, "INSERT INTO `clients` (`name`, `telephone`, `email`, `password`, `date`) VALUES ('$name', '$telephone', '$email', '$password', '$date')");

        setcookie('telephone', $telephone);
        setcookie('password', $password);

        header('Location: index.php');
    }else{
        echo "Ошибка";
    }


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="name" placeholder="Введите имя">
        <input type="text" name="telephone" placeholder="Введите телефон">
        <input type="text" name="email" placeholder="Введите email">
        <input type="text" name="password" placeholder="Введите пароль">
        <input type="submit" name="submit" value="Зарегистрироваться">
        <a href="login.php">Авторизация</a>
    </form>
</body>
</html>