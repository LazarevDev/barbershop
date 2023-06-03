<?php 
require_once('../require/db.php');

$loginCookie = $_COOKIE['login'];


if(isset($_GET['page'])){
    $idPage = $_GET['page'];

    if($idPage == 1){
        // Вывод всех отзывов
        $statusReview = 'status';
        $titleReview = "Все отзывы";
    }elseif($idPage == 2){
        // Вывод ожидания
        $statusReview = '0';
        $titleReview = "Отзывы ожидающие действия";
    }elseif($idPage == 3){
        // Вывод одобренных
        $statusReview = '1';
        $titleReview = "Одобренные отзывы";
    }elseif($idPage == 4){
        // Вывод отклоненных
        $statusReview = '2';
        $titleReview = "Отклоненные отзывы";
    }
}else{
    header('Location: review.php?page=1');
    exit;
}


if(isset($_GET['delete']) and isset($_GET['page'])){
    $deleteIdResponse = $_GET['delete'];
    $idPage = $_GET['page'];

    $queryDeleteResponse = mysqli_query($db, "DELETE FROM `response` WHERE `id` = '$deleteIdResponse'");

    header('Location: review.php?page='.$idPage);
    exit;

}

function whileReview($db, $statusReview){
    $queryRowReviews = mysqli_query($db, "SELECT * FROM `clients` INNER JOIN `review` ON review.telephone = clients.telephone WHERE `status` = $statusReview");
    while ($rowReviews = mysqli_fetch_array($queryRowReviews)) { 
        $idReviews = $rowReviews['id'];
        ?>
        <div class="reviewBlock">
            <div class="reviewProductImg">
                <img src="../img/products-cover/2305140/ayxnkcmh46umwpgvjxitr4u8iztplmey 1.png" alt="">
            </div>

            <div class="reviewBlockContent">
                <h2><?php echo $rowReviews['name']; ?></h2>
                
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

                <h3><?php echo $rowReviews['datetime']; ?></h3>
                <p><?php echo $rowReviews['text']; ?></p>
            </div>
        </div>

        <?php 
        $queryResponse = mysqli_query($db, "SELECT * FROM `response` WHERE `id_review` = '$idReviews'");
        while($rowResponse = mysqli_fetch_array($queryResponse)) { ?>
            <div class="responseBlock">
                <div class="responseText">
                    <h2>Администратор: <?php echo $rowResponse['sender']; ?></h2>
                    <p><?php echo $rowResponse['text']; ?></p>

                    <a href="review.php?page=<?php echo $_GET['page']."&delete=".$rowResponse['id']; ?>">Удалить ответ</a>
                </div>
            </div>
        <?php } ?>

        <form action="" method="post" class="responseForm">
            <input type="hidden" name="id_review" value="<?php echo $rowReviews['id']; ?>">
            <textarea name="text" id="" cols="30" rows="10" placeholder="Введите ответ на отзыв"></textarea>
        
            <div class="btnFormContainer">
                <input type="submit" class="submit" name="submit" value="Одобрить">
                <input type="submit" class="cancel" name="cancel" value="Отклонить">    
            </div>
        </form>
    <?php } 
}

if(isset($_POST['submit'])){
    $id_review = $_POST['id_review']; 
    $text = $_POST['text'];
    $sender = $loginCookie;
    $datetime = date("Y-m-d H:i:s");

    if(empty($text)){
        $updateReview = mysqli_query($db, "UPDATE `review` SET `status` = '1' WHERE `id` = '$id_review'");

    }else{
        $insertResponse = mysqli_query($db, "INSERT INTO `response` (`id_review`, `text`, `sender`, `datetime`) 
        VALUES ('$id_review', '$text', '$sender', '$datetime')");
    
        $updateReview = mysqli_query($db, "UPDATE `review` SET `status` = '1' WHERE `id` = '$id_review'");
    }
}


if(isset($_POST['cancel'])){
    $id_review = $_POST['id_review'];
    $cancel = $_POST['cancel'];
    $updateReview = mysqli_query($db, "UPDATE `review` SET `status` = '2' WHERE `id` = '$id_review'");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/review.css">
    <title>Document</title>
</head>
<body>
    <main>
        <?php require_once('include/menu.php'); ?>

        <section class="section">
            <!-- <div class="sectionTitle">
                <h2>Тип отзывов</h2>
            </div>

            <div class="content">
                <div class="reviewContainerBtn">
                    <a href="review.php?page=1" class="reviewBtn">Все отзывы</a>
                    <a href="review.php?page=2" class="reviewBtn">В ожидании</a>
                    <a href="review.php?page=3" class="reviewBtn">Разрешенные</a>
                    <a href="review.php?page=4" class="reviewBtn">Отклоненные</a>
                </div>
            </div>
         -->
            <div class="sectionTitle">
                <h2><?php  echo $titleReview; ?></h2>
            </div>

            <div class="content">
                <div class="reviewContainerBtn">
                    <a href="review.php?page=1" class="reviewBtn">Все отзывы</a>
                    <a href="review.php?page=2" class="reviewBtn">В ожидании</a>
                    <a href="review.php?page=3" class="reviewBtn">Разрешенные</a>
                    <a href="review.php?page=4" class="reviewBtn">Отклоненные</a>
                </div>

                <div class="reviewContent">
                <?php whileReview($db, $statusReview); ?>
                </div>
            </div>
        </section>
    </main>
</body>
</html>