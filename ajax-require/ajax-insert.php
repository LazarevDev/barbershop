<?php 
session_start();
require_once('../require/db.php');

$telephone = $_COOKIE['telephone'];

if(isset($_GET['time'])){

    $time = $_GET['time'];
    $staff = $_SESSION['staff'];
    $service = $_SESSION['service'];

    $queryCheque = mysqli_query($db, "SELECT * FROM `cheque` ORDER BY `id` DESC");
    $resultQueryCheque = mysqli_fetch_array($queryCheque);

    if(empty($resultQueryCheque['id'])){
        $idCheque = '0';
    }else{
        $idCheque = $resultQueryCheque['id'];
    }

    $date = date('Y-m-d H:i:s');
    $title = $idCheque."-".$date;


    $queryInsertCheque = mysqli_query($db, "INSERT INTO `cheque` (`title`, `client`, `datetime`) VALUES ('$title', '$telephone', '$time')") or die(mysqli_error($queryInsertCheque));

    $queryService = mysqli_query($db, "SELECT * FROM `services` WHERE `id` = '$service'");
    $resultQueryService = mysqli_fetch_array($queryService);
    $price = $resultQueryService['price'];
    $idCheque += 1;

    $queryInsertChequeInfo = mysqli_query($db, "INSERT INTO `cheque_info` (`title`, `price`, `staff`, `id_cheque`) VALUES ('$service', '$price', '$staff', '$idCheque')");

}

session_destroy();
header('Location: ../index.php');
exit;

?>