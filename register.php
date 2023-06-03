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

require_once('include/header.php');
?>

<link rel="stylesheet" href="panel/css/login.css">

    <form action="" method="post">

    </form>

<section class="login">
    <div class="container">
        <div class="center">
            <form action="" method="post" class="formLogin">
                <input type="text" name="name" placeholder="Введите имя">
                <input type="text" name="telephone" class="tel" placeholder="Введите телефон">
                <input type="text" name="email" placeholder="Введите email">
                <input type="password" name="password" placeholder="Введите пароль">
                <input type="submit" name="submit" class="submitLogin" value="Зарегистрироваться">
                <a href="login.php">Авторизация</a>
            </form>
        </div>
    </div>
</section>

<?php require_once('include/footer.php'); ?>