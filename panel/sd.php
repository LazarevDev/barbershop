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
    $checkbox = $_POST['checkbox'];
    $datetime_start = $_POST['datetime_start'];
    $datetime_end = $_POST['datetime_end'];


    echo $datetime_start."<br>".$datetime_end;

    print_r($_POST['login']);
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
                        <?php $queryStaffList = mysqli_query($db, "SELECT * FROM `staff` LEFT JOIN `work_schedule` ON staff.login = work_schedule.login  ORDER BY staff.id DESC");
                        while ($rowList = mysqli_fetch_array($queryStaffList)) { 
                            
                                      
                                      
                                      ?>
                            <div class="staffFormCheck">
                                <?php for ($i=0; $i < $t; $i++) { 
                                    $date = date('m.d');
                                    $timestamp = date("m.d", strtotime("+".$i." day", strtotime($date)));
                                    ?> 
                                    <label for="<?php echo $rowList['login'].$i; ?>">
                                        <input type="checkbox" value="<?php echo $timestamp; ?>" class="checkbox" name="checkbox[]" id="<?php echo $rowList['login'].$i; ?>">
                                    
                                        <input type="checkbox" name="login[]" value="<?php echo $rowList['login']; ?>"  id="<?php echo $rowList['login'].$i; ?>">
                                    <?php 
                                        $dateStart = $rowList['datetime_start'];
                                        $createDateStart = new DateTime($dateStart);
                                        
                                        $strip = $createDateStart->format('m.d');
                                        $timeStart = $createDateStart->format('H:i:s');

                                        $dateEnd = $rowList['datetime_end'];
                                        $createDateEnd = new DateTime($dateEnd);

                                        $timeEnd = $createDateEnd->format('H:i:s');

                                        if($strip == $timestamp){
                                            if(!empty($rowList['login'])){?> 
                                                <p>c <?php echo $timeStart; ?></p>
                                                <p>до <?php echo $timeEnd; ?></p>
                                            <?php }else{

                                            }
                                        }
                                      ?>
                                    </label>
                                <?php } ?>
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