<?php 
session_start();
require_once('../require/db.php');



if(!empty($_SESSION['staff'])){
    if(isset($_POST['staff'])){
        $_SESSION['staff'] = $_POST['staff'];
    }
}else{
    $_SESSION['staff'] = $_POST['staff'];
}

$loginStaff = $_SESSION['staff'];



$montArray = ['01' => 'Янв ', '02' => 'Фев ', '03' => 'Мар ', '04' => 'Апр ', '05' => 'Май ', '06' => 'Июн ', '07' => 'Июл '
, '08' => 'Авг ', '09' => 'Сент ', '10' => 'Окт ', '11' => 'Ноя ', '12' => 'Дек '];

?>

<div id="content">
    <h2>Выбор даты и времени</h2>
    <link rel="stylesheet" href="../css/normalize.css">

<link rel="stylesheet" href="../css/ajax-content.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


<div class="contentMonth">
    <div class="monthContainer">
        <?php $t = date('t');
        $dateStart = date('Y-m-d');


        
        // Добавление в массив зарегистрированных дат 

        $queryRow = mysqli_query($db, "SELECT * FROM `work_schedule` WHERE `login` = '$loginStaff' and `datetime_start` >= '$dateStart' ORDER BY datetime_start DESC");
        while ($row = mysqli_fetch_array($queryRow)) {
            $originalDate = $row['datetime_start'];
            $newDate = date("Y-m-d", strtotime($originalDate));
            $rowArray[] = $newDate;

        }

        // вывод кол-ва дней в месяц
    
        for ($i=0; $i < $t; $i++) { 
            $date = date('Y-m-d');
            $timestamp = date("d", strtotime("+".$i." day", strtotime($date))); 
            $timestampNew[] = date("Y-m-d", strtotime("+".$i." day", strtotime($date)));
            

            
            ?>
            <a class="monthBlock 
            <?php 

            if(!empty($_POST['date'])){
                if($_POST['date'] == $timestampNew[$i]){
                    echo " montBlockActive ";
                }
            }else{
                if($timestampNew[$i] == $date){
                    echo " montBlockActive ";  
                }
            }

            if(array_search($timestampNew[$i], $rowArray) !== false){
                echo "montBlockDate";
            }
            ?> "
                <?php 

                if(array_search($timestampNew[$i], $rowArray) !== false){
                    echo "href=".$timestampNew[$i];
                }
            ?>
            >


                <div class="monthBlockText">
                <?php echo "<p>".$montArray[date("m", strtotime("+".$i." day", strtotime($date)))]."</p><p>".$timestamp."</p>"; ?>
                </div>
            </a>
        <?php }

        // схождение массивов
        for ($id=0; $id < $t; $id++) { 
            $result = array_intersect($rowArray, $timestampNew);

        }
        ?>
    </div>
</div>

<?php 

// var_dump($result); 


if(!empty($_POST['date'])){
    $datetimeStartTest = date("Y-m-d", strtotime($_POST['date']))." 00:00:00";
    $datetimeEndTest = date("Y-m-d", strtotime($_POST['date']))." 23:59:59";

    $queryAuthDate = mysqli_query($db, "SELECT * FROM `work_schedule` WHERE `login` = '$loginStaff' AND `datetime_start` >= '$datetimeStartTest' AND `datetime_end` <= '$datetimeEndTest'");
    $resultAuthDate = mysqli_fetch_array($queryAuthDate);
    $AuthDate = $resultAuthDate['datetime_start'];
    $newDateAuth = date("Y-m-d", strtotime($AuthDate));

    if($_POST['date'] == $newDateAuth){ 
        dateTimeContent($db, $loginStaff, $newDate, $originalDate); 
    }else{
        echo "Записей нет";
    }
}else{

    if($newDate == $date){
        dateTimeContent($db, $loginStaff, $newDate, $originalDate); 
    }else{ ?>
        <div class="containerBlock">
            <div class="noBlockDateTime">
                <p>В этот день записей нет</p>
            </div>
        </div>
    <?php
    }
}



function dateTimeContent($db, $loginStaff, $newDate, $originalDate){ ?>
    <div class="containerBlock">
    <?php 
    
    if(!empty($_POST['date'])){
        $time = date("Y-m-d", strtotime($_POST['date']))." 00:00:00";
        $timeEnd = date("Y-m-d", strtotime($_POST['date']))." 23:59:59";
    }else{
        $time = $originalDate;
        $timeEnd = $newDate." 23:59:59";

    }




    $queryRow = mysqli_query($db, "SELECT * FROM `work_schedule` WHERE `login` = '$loginStaff' AND `datetime_start` >= '$time' AND `datetime_end` <= '$timeEnd' ORDER BY `id` DESC");
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
    
        // забронированное время;
        $ztime = "08:00";


        for ($i=0; $i < $diffCount; $i++) {

            for ($i=0; $i < $diffCount; $i++) { 

                $diffMinutes = $i * 30;
    
                $timestamp = date("H:i", strtotime("+".$diffMinutes." minutes", strtotime($row['datetime_start'])));
                $timestampHref = date("Y-m-d", strtotime($time))." ".$timestamp.":00";
                if($timestamp == $ztime){
                }

                ?> 

                <a href="<?php if($timestamp == $ztime){  }else{ echo "ajax-require/ajax-insert.php?time=".$timestampHref; } ?>" class='timeBtn'><?php echo $timestamp; ?></a>
                <?php
            }
        }
    }
    
    
    
            ?>
    </div>
</div>
<?php } ?>
    


    
<script>
    $(function(){
        $('.monthContainer').on('click','.monthBlock', function(e) {
            e.preventDefault();
            var date = $(this).attr('href');
            $.ajax({
            url: '../ajax-require/ajax-datetime.php', 
            type: 'POST', 
            data: {date : date},
            success: function(data){
                jQuery('#content').html(data);
                
                setTimeout ("$('#content')", 500);
            }
            });
        });
    });

</script>
