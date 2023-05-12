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











if(isset($_POST['submit'])){
    $datetimeStart = $_POST['datetime_start'];
    $datetimeEnd = $_POST['datetime_end'];
    // $login = $_POST['login'];
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
    }
}


function strip($db, $rowStaffListLogin, $timestamp){

    $queryWorkSchedule = mysqli_query($db, "SELECT * FROM `work_schedule` WHERE `login` = '$rowStaffListLogin'");
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/work_schedule.css">
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
                <h2>График работы персонала</h2>
            </div>

            <form action="" method="post">

                <div class="formInput">
                    <label for="">
                        <p>Со скольки</p>
                        <input type="time" name="datetime_start" value="08:00">
                    </label>

                    <label for="">
                        <p>До скольки</p>
                        <input type="time" name="datetime_end" value="19:00">
                    </label>

                    <input type="submit" name="submit" value="submit">
                </div>


                <div class="contentTable">
                    <div class="staffList">
                        <div class="staffTitle">
                            <p>Стафф</p>
                        </div>
                        <?php 
                        $queryStaffList = mysqli_query($db, "SELECT * FROM `staff` ORDER BY `id` DESC");
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
                                $timestamp = date("m.d", strtotime("+".$i." day", strtotime($date))); ?>
                                <div class="monthBlock">
                                    <?php echo $timestamp; ?>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="staffFormCheckCont">
                            <?php $queryStaffList = mysqli_query($db, "SELECT * FROM `staff` ORDER BY `id` DESC");
                            while ($rowStaffList = mysqli_fetch_array($queryStaffList)) {
                                $rowStaffListLogin = $rowStaffList['login']; ?>
                                <div class="staffFormCheck">
                                    <?php for ($i=0; $i < $t; $i++) { 
                                        $date = date('Y-m-d');
                                        $timestamp = date("Y-m-d", strtotime("+".$i." day", strtotime($date)));

                                        $arrayDateLogin = array('date' => $timestamp, 'login' => $rowStaffListLogin);
                                        ?> 
                                        <label <?php 
                                            if(strip($db, $rowStaffListLogin, $timestamp) !== '0'){
                                                if(!empty(strip($db, $rowStaffListLogin, $timestamp)[1])){
                                                echo "class='labelActive'";
                                                }
                                            }
                                            ?>
                                            
                                            for="<?php echo $rowStaffList['login'].$i; ?>">
                                            <input type="checkbox" name="date[]" id="<?php echo $rowStaffListLogin.$i; ?>"  value="<?php echo $timestamp."*".$rowStaffListLogin; ?>">

                                            <?php 
                                                if(strip($db, $rowStaffListLogin, $timestamp) !== '0'){
                                                    if(!empty(strip($db, $rowStaffListLogin, $timestamp)[1])){
                                                        echo "<p> c ".strip($db, $rowStaffListLogin, $timestamp)[1]."</p>";
                                                        echo "<p> до ".strip($db, $rowStaffListLogin, $timestamp)[2]."</p>";
                                                    }
                                                }
                                            ?>
                                        </label>
                                    <?php }  ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
</body>
</html>