<?php 
setcookie('login', null, -1, '/'); 
setcookie('password', null, -1, '/'); 

header('Location: ../index.php');

?>