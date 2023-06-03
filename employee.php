<?php 
include_once('include/header.php'); 


if(isset($_GET['id'])){
    $staffId = $_GET['id'];

    $queryStaff = mysqli_query($db, "SELECT * FROM `staff` WHERE `id` = '$staffId'");
    $resultStaff = mysqli_fetch_array($queryStaff);

    $staff = $resultStaff['login'];
}



if(isset($_POST['submit'])){
    $rating = $_POST['rating'];
    $text = $_POST['text'];
    $datetime = date("Y-m-d H:i:s");


    $ratingInsert = mysqli_query($db, "INSERT INTO `review` (`telephone`, `rating`, `text`, `staff`, `datetime`) VALUES ('$cookieTelephone', '$rating', '$text', '$staff', '$datetime')") or die(mysqli_error($ratingInsert));
   
    header("Location: employee.php?id=".$staffId);
    exit;
}


// Подсчет рейтинга

$queryRatingSum = mysqli_query($db, "SELECT SUM(id) id FROM `review` WHERE `staff` = '$staff' AND `status` = '1'");
$resultRatingSum = mysqli_fetch_array($queryRatingSum);


$queryRowRating = mysqli_query($db, "SELECT * FROM `review` WHERE `staff` = '$staff' AND `status` = '1'");
while ($rowRating = mysqli_fetch_array($queryRowRating)) { 

    $asr[] = ($rowRating['rating'] * $rowRating['id']);

}

if(empty($asr)){
    $ratingSum = 0;
}else{
    $ratingSum = round(array_sum($asr)/$resultRatingSum['id'], 1);

}

?>

<link rel="stylesheet" href="css/employee.css">

<section class="employee">
    <div class="container">

        <div class="employeeContent">
            <div class="employeeContentLeft">
                <div class="employeePhoto">
                    <img src="img/admin-photo/<?php echo $resultStaff['login']."/".$resultStaff['photo']; ?>" alt="">
                </div>
            </div>

            <div class="employeeContentRight">
            
                <div class="employeeName">
                    <h2><?php echo $resultStaff['name']; ?></h2>
                    <p>Рейтинг: <?php echo $ratingSum; ?></p>
                    <p><?php if($resultStaff['specialization'] == "0"){ echo "Младший барбер"; }elseif($resultStaff['specialization'] == "1"){ echo "Старший барбер"; } ?></p>
                </div>

                <div class="employeeDescription">
                    <h2>Описание:</h2>
                    <p><?php echo $resultStaff['description']; ?></p>
                </div>

                <div class="employeeReviews">
                    <h2>Отзывы</h2>

                    <?php
                    
                    if(!empty($resultClient)){ ?>
                        <form action="" method="post">
                            <div class="ratingArea">
                                <input type="radio" id="star-5" name="rating" value="5">
                                <label for="star-5" title="Оценка «5»"></label>	
                                <input type="radio" id="star-4" name="rating" value="4">
                                <label for="star-4" title="Оценка «4»"></label>    
                                <input type="radio" id="star-3" name="rating" value="3">
                                <label for="star-3" title="Оценка «3»"></label>  
                                <input type="radio" id="star-2" name="rating" value="2">
                                <label for="star-2" title="Оценка «2»"></label>    
                                <input type="radio" id="star-1" name="rating" value="1">
                                <label for="star-1" title="Оценка «1»"></label>
                            </div>

                            <textarea class="employeeTextarea" name="text" id="" cols="30" rows="10" placeholder="Опишите плюсы и минусы"></textarea>
                            <input type="submit" name="submit" class="submit" value="Отправить">
                        </form>
                    <?php }else{ ?>
                        <div class="employeeReviewsMsg">
                            <p>Чтобы оставить отзыв, Вам необходимо авторизоваться <a href="login.php">Авторизация</a></p>
                        </div>
                    <?php }
                    
                    ?>

                    <div class="employeeReviewsContent">
                        <?php 
                        $queryRowReviews = mysqli_query($db, "SELECT * FROM `clients` LEFT JOIN `review` ON review.telephone = clients.telephone WHERE review.staff = '$staff' AND review.status = '1'");
                        while ($rowReviews = mysqli_fetch_array($queryRowReviews)) {
                            
                            $id_review = $rowReviews['id'];
                            ?>
                            <div class="reviewsBlock">
                                <h2><?php echo $rowReviews['name']; ?></h2>

                                <div class="ratingResultContainer">
                                    <div class="ratingResult">
                                        <?php 
                                        for ($i=0; $i < $rowReviews['rating']; $i++) { ?>
                                            <span class="ratingResultActive"></span>	
                                            
                                        <?php } 
                                        
                                        $spanReviewSum = 5 - $rowReviews['rating'];

                                        for ($i=0; $i < $spanReviewSum; $i++) { ?>
                                            <span></span>	
                                        <?php } 
                                        ?>
                                    </div>

                                    <p>25.05.2023</p>
                                </div>
                                
                                <p><?php echo $rowReviews['text']; ?></p>
                            </div>
                            <?php 
                       $queryRowResponse = mysqli_query($db, "SELECT * FROM `response` LEFT JOIN `staff` ON response.sender = staff.login WHERE response.id_review = '$id_review'");
                       while ($rowResponse = mysqli_fetch_array($queryRowResponse)) { ?>

                        <div class="responseReview">
                            <div class="responseReviewHeader">
                                <h2>Администратор: <?php echo $rowResponse['name']; ?></h2>
                            </div>

                            <div class="responseReviewFooter">
                                <p><?php echo $rowResponse['text']; ?> </p>
                            </div>
                        </div>
                        <?php } ?>
                        <?php } ?>

                       
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?php include_once('include/footer.php'); ?>