<?php 
include_once('include/header.php'); 

if(!$resultClient){
    header('Location: login.php');
    exit;
}

?>

<link rel="stylesheet" href="css/profile.css">

<section class="profile">
    <div class="container">
        <div class="profileContent">
            <h2>добро пожаловать!</h2>
            <a href="logout.php">Выход</a>
        </div>
    </div>
</section>



<?php include_once('include/footer.php'); ?>