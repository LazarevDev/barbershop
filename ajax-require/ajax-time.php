<?php 
require_once('../require/db.php');



// echo $_POST['staff']." ".$_POST['service'];

$loginStaff = $_POST['staff'];
$idService = $_POST['service'];


$queryRow = mysqli_query($db, "SELECT * FROM `work_schedule` WHERE `login` = '$loginStaff'");
while ($row = mysqli_fetch_array($queryRow)) {

    // Узнаем кол-во рабочих часов
    $datetimeStart = new DateTime($row['datetime_start']);
    $datetimeEnd = new DateTime($row['datetime_end']);
    $diff = $datetimeEnd->diff($datetimeStart);
    $diffHours = $diff->h;
    $diffCount = $diffHours * 2;


    if(!empty($diff->i)){
        $diffMinutes = $diff->i;
        $diffCount = $diffCount + 1;
    }


    for ($i=0; $i < $diffCount; $i++) {
        // 15 записей

        for ($i=0; $i < $diffCount; $i++) { 
            $diffMinutes = $i * 30;

            $timestamp = date("H:i", strtotime("+".$diffMinutes." minutes", strtotime($row['datetime_start'])));
            echo "<div class='block'>".$timestamp."</div>";
        }
    }
}
?>