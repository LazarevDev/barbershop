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
            <h2>Сергей, добро пожаловать!</h2>
        </div>
    </div>
</section>



<?php include_once('include/footer.php'); ?>