<?php 
require_once('../require/db.php');

$loginCookie = $_COOKIE['login'];

if(isset($_POST['submit'])){
    $id_review = $_POST['id_review']; 
    $text = $_POST['text'];
    $sender = $loginCookie;
    $datetime = date("Y-m-d H:i:s");

    $insertResponse = mysqli_query($db, "INSERT INTO `response` (`id_review`, `text`, `sender`, `datetime`) 
    VALUES ('$id_review', '$text', '$sender', '$datetime')");

    $updateReview = mysqli_query($db, "UPDATE `review` SET `status` = '1' WHERE `id` = '$id_review'");
}

require_once('include/function.php');
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
            <div class="sectionTitle">
                <h2>Отзывы</h2>
            </div>

            <div class="content">
                <div class="reviewContent">
                <?php 
                    $queryRowReviews = mysqli_query($db, "SELECT * FROM `clients` INNER JOIN `review` ON review.telephone = clients.telephone");
                    while ($rowReviews = mysqli_fetch_array($queryRowReviews)) { ?>
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

                        <form action="" method="post">
                            <input type="text" name="id_review" value="<?php echo $rowReviews['id']; ?>">
                            <textarea name="text" id="" cols="30" rows="10"></textarea>
                            <input type="submit" name="submit" value="Отправить">
                        </form>
                    <?php } ?>
                </div>
            </div>
        </section>
    </main>
</body>
</html>