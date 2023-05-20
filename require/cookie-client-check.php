<?php 
    if(!empty($_COOKIE['telephone']) AND !empty($_COOKIE['password'])){
        $cookieTelephone = $_COOKIE['telephone'];
        $cookiePassword = $_COOKIE['password'];

        $queryClient = mysqli_query($db, "SELECT * FROM `clients` WHERE `telephone` = '$cookieTelephone' AND `password` = '$cookiePassword'");
        $resultClient = mysqli_fetch_array($queryClient);

        if(!$resultClient){
            setcookie('telephone', null, -1, '/');
            setcookie('password', null, -1, '/');
        }
    }else{
        setcookie('telephone', null, -1, '/');
        setcookie('password', null, -1, '/');
    }
?>