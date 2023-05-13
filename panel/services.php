<?php 
require_once('../require/db.php');



if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $receptionTime = $_POST['receptionTime'];

    $queryAddService = "INSERT INTO `services` (`title`, `category`, `description`, `price`, `reception_time`) 
    VALUES ('$title', '$category', '$description', '$price', '$receptionTime')";
    $resultAddService = mysqli_query($db, $queryAddService) or die(mysqli_error($db));


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
    <link rel="stylesheet" href="css/services.css">
    <title>Document</title>
</head>
<body>
    <main>
        <?php require_once('include/menu.php'); ?>

        <section class="section">
            <div class="sectionTitle">
                <h2>Услуги</h2>
            </div>

            <div class="content">
                <form action="" class="formCategory" method="post">
                    <input class="formCategoryInput" type="text" name="category" list="category" placeholder="Введите категорию">
                    
                    <datalist id="category">
                        <option value="Название1"> 
                        <option value="Название2">
                    </datalist>
                    
                    <input class="formCategoryInput" name="title" type="text" placeholder="Введите название услуги">
                    <input class="formCategoryInput" name="price" type="text" placeholder="Введите стоимость">
                    <input class="formCategoryInput" name="receptionTime" type="text" placeholder="Введите время приема в минутах">
                    <textarea name="description" id="" class="formCategoryInput formCategoryTextarea" placeholder="Введите описание для усгуи"></textarea>

                    <div class="formCategorySubmitContent">
                        <input class="formCategorySubmit" name="submit" type="submit" value="Опубликовать">
                    </div>
                </form>
            </div>

            <div class="sectionTitle">
                <h2>Все услуги</h2>
            </div>

            <div class="content">
                <div class="servicesContent">
                    <?php $queryServiceCategory = mysqli_query($db, "SELECT DISTINCT category FROM `services`");
                    while($rowCategory = mysqli_fetch_array($queryServiceCategory)){
                        $category = $rowCategory['category']; ?>
                        <div class="servicesCategory">
                            <div class="servicesCategoryTitle">
                                <h2><?php echo $category; ?></h2>
                            </div>

                            <?php $queryService = mysqli_query($db, "SELECT * FROM `services` WHERE `category` = '$category'");
                            while($rowService = mysqli_fetch_array($queryService)){ ?>
                                <div class="servicesBlock">
                                    <p><?php echo $rowService['title']; ?> - <?php echo $rowService['price']; ?> руб.</p>

                                    <div class="servicesBlockActive">
                                        <a class="edit" href="">Редактировать</a>
                                        <a class="delete" href="">Удалить</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    </main>
</body>
</html>