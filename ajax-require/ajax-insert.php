<?php 
session_start();
require_once('../require/db.php');

$telephone = $_COOKIE['telephone'];

if(empty($_COOKIE['telephone'])){
    header('Location: ../login.php');
}else{

}

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
    $idCheque += 1;

    $title = $idCheque."-".$date;

    $queryInsertCheque = mysqli_query($db, "INSERT INTO `cheque` (`title`, `client`, `datetime`) VALUES ('$title', '$telephone', '$date')") or die(mysqli_error($queryInsertCheque));
    $queryInsertChequeInfo = mysqli_query($db, "INSERT INTO `cheque_info` (`id_service`, `staff`, `id_cheque`, `datetime`) VALUES ('$service', '$staff', '$idCheque', '$time')") or die(mysqli_error($queryInsertChequeInfo));

}

session_destroy();
header('Location: ../index.php');
exit;

?>