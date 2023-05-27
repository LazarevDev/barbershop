<?php 
$db = mysqli_connect('192.168.0.16', 'admin', 'admin', 'barbershop') or die(mysqli_error($db));
mysqli_set_charset($db , 'utf-8');
?>