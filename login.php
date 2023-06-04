<?php 
require_once('require/db.php');

if(isset($_POST['submit'])){
    $telephone = $_POST['telephone'];
    echo $telephone;
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

require_once('include/header.php');
?>

<link rel="stylesheet" href="panel/css/login.css">


<section class="login">
    <div class="container">
        <div class="center">
            <form action="" method="post" class="formLogin">
                <h2>Вход</h2>
                <input type="text" name="telephone" class="tel" placeholder="Введите телефон">
                <input type="password" name="password" placeholder="Введите пароль">
                <input type="submit" class="submitLogin" name="submit" value="Войти">
                <a href="register.php">Регистрация</a>
            </form>
        </div>

        <div class="center">
            <div class="formPolitica">
                <p>нажимая на кнопку вы соглашаетесь на обработку <a href="documents/politica.html">персональных данных</a></p>
            </div>
        </div>
    </div>
</section>

<?php require_once('include/footer.php'); ?>