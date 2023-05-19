<?php 
session_start();
require_once('../require/db.php');



// echo $_POST['staff']." ".$_POST['service'];

$loginStaff = $_POST['staff'];
// $idService = $_POST['service'];



$montArray = ['01' => 'Янв ', '02' => 'Фев ', '03' => 'Мар ', '04' => 'Апр ', '05' => 'Май ', '06' => 'Июн ', '07' => 'Июл '
, '08' => 'Авг ', '09' => 'Сент ', '10' => 'Окт ', '11' => 'Ноя ', '12' => 'Дек '];

?>

<div id="content">
    
<link rel="stylesheet" href="ajax-require/style.css">
<link rel="stylesheet" href="style.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


<div class="contentMonth">
<div class="monthContainer">
    <?php $t = date('t');


    $queryRow = mysqli_query($db, "SELECT * FROM `work_schedule` WHERE `login` = 'lazarev' ORDER BY id DESC");
    while ($row = mysqli_fetch_array($queryRow)) {
        $originalDate = $row['datetime_start'];
        $newDate = date("Y-m-d", strtotime($originalDate));
        $rowArray[] = $newDate;
    }

    for ($i=0; $i < $t; $i++) { 
    

        $date = date('Y-m-d');
        $timestamp = date("d", strtotime("+".$i." day", strtotime($date))); 
        $timestampNew[] = date("Y-m-d", strtotime("+".$i." day", strtotime($date))); 
        ?>
        <div class="monthBlock">
            <?php 
            // схождение массивов
            $result = array_intersect($rowArray, $timestampNew);

            for ($f=0; $f < count($result); $f++) { 
                if($rowArray[$i] == $timestampNew[$i]){?>
                    <a class="dateBtn" href="<?php echo $result[$f]; ?>">Выборка</a>
                <?php
                }
            }
           
            echo "<p>".$montArray[date("m", strtotime("+".$i." day", strtotime($date)))]."</p><p>".$timestamp."</p>"; ?>
        </div>
    <?php } ?>
    </div>
    </div>


    <div class="containerBLOCk">
        <?php 
        
        if(!empty($_POST['time'])){
            $time = date("Y-m-d", strtotime($_POST['time']))." 00:00:00";
            $timeEnd = date("Y-m-d", strtotime($_POST['time']))." 23:59:59";
        }else{
            $time = $originalDate;
            $timeEnd = $newDate." 23:59:59";
        }


        $queryRow = mysqli_query($db, "SELECT * FROM `work_schedule` WHERE `login` = 'lazarev' AND `datetime_start` = '$time' AND `datetime_end` < '$timeEnd'");
        while ($row = mysqli_fetch_array($queryRow)) {
            // Узнаем кол-во рабочих часов
            $datetimeStart = new DateTime($row['datetime_start']);
            $datetimeEnd = new DateTime($row['datetime_end']);
            $diff = $datetimeEnd->diff($datetimeStart);
            $diffHours = $diff->h;
            $diffCount = $diffHours * 2;
        
        echo "sd";
            if(!empty($diff->i)){
                $diffMinutes = $diff->i;
                $diffCount = $diffCount + 1;
            }
        
        
            for ($i=0; $i < $diffCount; $i++) {
                for ($i=0; $i < $diffCount; $i++) { 
                    $diffMinutes = $i * 30;
        
                    $timestamp = date("H:i", strtotime("+".$diffMinutes." minutes", strtotime($row['datetime_start'])));
                    echo "<div class='block'>".$timestamp."</div>";
                }
            }
        }
        
        
        
                ?>
        </div>
    </div>


    
<script>
    $(function(){
        $('.monthBlock').on('click','.dateBtn', function(e) {
            e.preventDefault();
            var time = $(this).attr('href');
            $.ajax({
            url: '../ajax-require/ajax-datetime.php', 
            type: 'POST', 
            data: {time : time},
            success: function(data){
                jQuery('#content').html(data);
                
                setTimeout ("$('#content')", 500);
            }
            });
        });
    });
</script>
