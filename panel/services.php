<?php 
require_once('../require/db.php');

$arrayEdit = ['title' => null, 'category' => null, 'description' => null, 'price' => null, 'reception_time' => null];

if(isset($_GET['edit'])){
    $editId = $_GET['edit'];
    
    $queryEditService = mysqli_query($db, "SELECT * FROM `services` WHERE `id` = '$editId'");
    $resultEditService = mysqli_fetch_array($queryEditService);

    $arrayEdit = ['title' => $resultEditService['title'], 
                'category' => $resultEditService['category'], 
                'description' => $resultEditService['description'], 
                'price' => $resultEditService['price'], 
                'reception_time' => $resultEditService['reception_time']];

    if(isset($_POST['submit'])){
        $title = $_POST['title'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $receptionTime = $_POST['receptionTime'];
            
        $queryEditService = mysqli_query($db, "UPDATE `services` SET `title` = '$title', `category` = '$category', `price` = '$price', `description` = '$description', `reception_time` = '$receptionTime' WHERE `id` = '$editId'");
        header('Location: services.php');
        exit;
    }

}elseif(isset($_GET['delete'])){
    $deleteId = $_GET['delete'];

    $queryDelete = mysqli_query($db, "DELETE FROM `services` WHERE `id` = '$deleteId'");
    header('Location: services.php');
    exit;

}else{
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
                    <input class="formCategoryInput" type="text" name="category" list="category" placeholder="Введите категорию" <?php edit('input', $arrayEdit['category']); ?>>
                    
                    <datalist id="category">
                        <?php $queryServiceCategory = mysqli_query($db, "SELECT DISTINCT category FROM `services`");
                        while($rowCategory = mysqli_fetch_array($queryServiceCategory)){
                        $category = $rowCategory['category']; ?>
                            <option value="<?php echo $category; ?>"> 
                        <?php } ?>
                    </datalist>
                    
                    <input class="formCategoryInput" name="title" type="text" placeholder="Введите название услуги" <?php edit('input', $arrayEdit['title']); ?>>
                    <input class="formCategoryInput" name="price" type="text" placeholder="Введите стоимость" <?php edit('input', $arrayEdit['price']); ?>>
                    <input class="formCategoryInput" name="receptionTime" type="text" placeholder="Введите время приема в минутах" <?php edit('input', $arrayEdit['reception_time']); ?>>
                    <textarea name="description" id="" class="formCategoryInput formCategoryTextarea" placeholder="Введите описание для услуг" ><?php edit('textarea', $arrayEdit['description']); ?></textarea>

                    <div class="formCategorySubmitContent">
                        <input class="formCategorySubmit" name="submit" type="submit" value="Опубликовать">
                        <?php if(isset($_GET['edit'])){ ?><a class="formCategoryCancel" href="services.php">Отменить</a> <?php } ?>
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
                                        <a class="edit" href="services.php?edit=<?php echo $rowService['id']; ?>">Редактировать</a>
                                        <a class="delete" href="services.php?delete=<?php echo $rowService['id']; ?>">Удалить</a>
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