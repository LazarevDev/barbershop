<?php 
require_once('../require/db.php');


// проверка на куки 

if(!empty($_COOKIE['login']) OR !empty($_COOKIE['password'])){

    $loginCookie = $_COOKIE['login'];
    $passwordCookie = $_COOKIE['password'];

    $queryStaffCookie = mysqli_query($db, "SELECT * FROM `staff` WHERE `login` = '$loginCookie' and `password` = '$passwordCookie'");
    $resultStaffCookie = mysqli_fetch_array($queryStaffCookie);   
    
    if(!$resultStaffCookie){
        header('Location: login.php');
    }
}else{
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/statistics.css">
    <title>Document</title>

    <style>
        .content{
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            width: 650px;
            margin: 30px 0 0 0;
        }

        .block{
            display: flex;
            justify-content: center;

            width: 100px;
            header: 50px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            margin: 10px 0 0 0;
        }
    </style>
</head>
<body>
    <main>
        <?php require_once('include/menu.php'); ?>

        <section class="statistic">
            <div class="sectionTitle">
                <h2>График работы</h2>
            </div>

            <div class="content">
                <?php

                    $queryRow = mysqli_query($db, "SELECT * FROM `work_schedule` WHERE `login` = 'evg'");
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
            </div>
        </section>
    </main>
</body>
</html>