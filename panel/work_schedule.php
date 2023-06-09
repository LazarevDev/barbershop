<?php 
require_once('../require/db.php');



if(isset($_POST['submit'])){
    $datetimeStart = $_POST['datetime_start'];
    $datetimeEnd = $_POST['datetime_end'];
    $date = $_POST['date'];
    

    // Разделение date на части

    for ($i=0; $i < count($date); $i++) {
        $arrayTitle = array('date', 'login');
        $data = array_combine($arrayTitle, explode("*", $date[$i]));

        $newDatetimeStart = $data['date']." ".$datetimeStart.":00";
        $newDatetimeEnd = $data['date']." ".$datetimeEnd.":00";
        $login = $data['login'];

        $queryAddWorkSchedule = "INSERT INTO `work_schedule` (`datetime_start`, `datetime_end`, `login`) VALUES ('$newDatetimeStart', '$newDatetimeEnd', '$login')";
        $resultAddStaff = mysqli_query($db, $queryAddWorkSchedule) or die(mysqli_error($db));

        header('Location: work_schedule.php');
    }
}

if(isset($_POST['submitDelete'])){
    $date = $_POST['date'];

    for ($i=0; $i < count($date); $i++) {
        $arrayTitle = array('date', 'login');
        $data[] = array_combine($arrayTitle, explode("*", $date[$i]));

        $loginDelete = $data[$i]['login'];
        $dateDelete = $data[$i]['date'];

        $queryDatetime = mysqli_query($db, "SELECT * FROM `work_schedule` WHERE `login` = '$loginDelete' ORDER BY `id` DESC");
        while($rowDatetime = mysqli_fetch_array($queryDatetime)){
            $createDateStart = new DateTime($rowDatetime['datetime_start']);
            $stripDate = $createDateStart->format('Y-m-d');

            $createTimeStart = new DateTime($rowDatetime['datetime_start']);
            $stripTime = $createDateStart->format('H:i:s');


            if($stripDate == $dateDelete){
                $dateDelete = $rowDatetime['datetime_start'];

                $queryDelete = mysqli_query($db, "DELETE FROM `work_schedule` WHERE `login` = '$loginDelete' AND `datetime_start` = '$dateDelete'");
            }
        }


    }
    header('Location: work_schedule.php');
    exit;
}


function strip($db, $rowStaffListLogin, $timestamp){

    $queryWorkSchedule = mysqli_query($db, "SELECT * FROM `work_schedule` WHERE `login` = '$rowStaffListLogin' ORDER BY `id` DESC");
    while ($rowWorkSchedule = mysqli_fetch_array($queryWorkSchedule)) {
        $workScheduleLogin = $rowWorkSchedule['login'];
        $workScheduleStart = $rowWorkSchedule['datetime_start'];
        $workScheduleEnd = $rowWorkSchedule['datetime_end'];
    
        $dateStart = $workScheduleStart;
        $createDateStart = new DateTime($dateStart);
        
        $strip = $createDateStart->format('Y-m-d');
        $timeStart = $createDateStart->format('H:i:s');

        $dateEnd = $workScheduleEnd;
        $createDateEnd = new DateTime($dateEnd);

        $timeEnd = $createDateEnd->format('H:i:s');

        if($strip == $timestamp){
            if(!empty($workScheduleLogin)){
                $dataStrip = ['1', $timeStart, $timeEnd];
                return $dataStrip;
            }else{
                return 0;
            }
        }
     } 
}


$montArray = ['01' => 'Янв ', '02' => 'Фев ', '03' => 'Мар ', '04' => 'Апр ', '05' => 'Май ', '06' => 'Июн ', '07' => 'Июл '
, '08' => 'Авг ', '09' => 'Сент ', '10' => 'Окт ', '11' => 'Ноя ', '12' => 'Дек '];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/work_schedule.css">
    <title>Document</title>
</head>
<body>
    <main>
        <?php require_once('include/menu.php'); ?>

        <section class="section">
            <div class="sectionTitle">
                <h2>График работы персонала</h2>
            </div>

            <div class="content">
                <form action="" class="formContent" method="post">

                    <div class="formInput">
                        <label class="formInputLabel" for="">
                            <p>Рабочий день с</p>
                            <input type="time" name="datetime_start" value="08:00">
                        </label>

                        <label class="formInputLabel" for="">
                            <p>Рабочий день до</p>
                            <input type="time" name="datetime_end" value="19:00">
                        </label>

                        <input type="submit" name="submit" class="submit" value="Выставить">
                        <input type="submit" name="submitDelete" class="submitDelete" value="Удалить">
                    </div>


                    <div class="contentTable">
                        <div class="staffList">
                            <div class="staffTitle">
                                <p>Сотрудники</p>
                            </div>
                            <?php 
                            $queryStaffList = mysqli_query($db, "SELECT * FROM `staff` WHERE `specialization` != '2' ORDER BY `id` DESC");
                            while ($rowList = mysqli_fetch_array($queryStaffList)) { ?>
                                <div class="staffBlock">
                                    <?php echo $rowList['name']; ?>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="contentMonth">
                            <div class="monthContainer">
                                <?php $t = date('t');

                                for ($i=0; $i < $t; $i++) { 
                                    $date = date('m.d');
                                    $timestamp = date("d", strtotime("+".$i." day", strtotime($date))); ?>
                                    <div class="monthBlock">
                                        <?php echo $montArray[date("m", strtotime("+".$i." day", strtotime($date)))]." ".$timestamp; ?>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="staffFormCheckCont">
                                <?php $queryStaffList = mysqli_query($db, "SELECT * FROM `staff` WHERE `specialization` != '2' ORDER BY `id` DESC");
                                while ($rowStaffList = mysqli_fetch_array($queryStaffList)) {
                                    $rowStaffListLogin = $rowStaffList['login']; ?>
                                    <div class="staffFormCheck">
                                        <?php for ($i=0; $i < $t; $i++) { 
                                            $date = date('Y-m-d');
                                            $timestamp = date("Y-m-d", strtotime("+".$i." day", strtotime($date)));

                                            $arrayDateLogin = array('date' => $timestamp, 'login' => $rowStaffListLogin);
                                            ?> 
                                            <label class="staffFormCheckLabel <?php 
                                                if(strip($db, $rowStaffListLogin, $timestamp) !== '0'){
                                                    if(!empty(strip($db, $rowStaffListLogin, $timestamp)[1])){
                                                    echo "labelActive";
                                                    }
                                                } ?>"
                                                
                                                for="<?php echo $rowStaffList['login'].$i; ?>">
                                                <input type="checkbox" onchange="toggleCheck(this)" class="checkbox" name="date[]" id="<?php echo $rowStaffListLogin.$i; ?>"  value="<?php echo $timestamp."*".$rowStaffListLogin; ?>">

                                                <div class="labelCheckText">
                                                    <?php 
                                                        if(strip($db, $rowStaffListLogin, $timestamp) !== '0'){
                                                            if(!empty(strip($db, $rowStaffListLogin, $timestamp)[1])){
                                                                echo "<p>С ".strip($db, $rowStaffListLogin, $timestamp)[1]."</p>";
                                                                echo "<p>До ".strip($db, $rowStaffListLogin, $timestamp)[2]."</p>";
                                                            }else{
                                                                echo "<p>Выходной</p>";
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </label>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    </form>
            </div>
        </section>
    </main>

    <script>
        function toggleCheck(elem) {
            $(elem).parent().toggleClass('labelCheck')
        }
    </script>
</body>
</html>