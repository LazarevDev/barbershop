<?php 
if(isset($_COOKIE['login'])) {
    $loginCookie = $_COOKIE['login'];
    if(isset($_COOKIE['password'])) {
        $passwordCookie = $_COOKIE['password'];
        $queryCookie = mysqli_query($db, "SELECT * FROM `staff` WHERE `login` = '$loginCookie' and `password` = '$passwordCookie'");
        $resultCookie = mysqli_fetch_array($queryCookie);

        if($resultCookie) {
        } else {
            header('Location: login.php');
        }
    } else {
        header('Location: login.php');
    }
} else {
    header('Location: login.php');
}
?>