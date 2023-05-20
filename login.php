<?php 
require_once('require/db.php');

if(isset($_POST['submit'])){
    $telephone = $_POST['telephone'];
    $password = md5($_POST['password']);

    $queryClientCheck = mysqli_query($db, "SELECT * FROM `clients` WHERE `telephone` = '$telephone' AND `password` = '$password'");
    $resultClientCheck = mysqli_fetch_array($queryClientCheck);

    if($resultClientCheck){
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
        <input type="text" name="telephone" placeholder="Введите телефон">
        <input type="text" name="password" placeholder="Введите пароль">
        <input type="submit" name="submit" value="Войти">
        <a href="login.php">Регистрация</a>
    </form>
</body>
</html>