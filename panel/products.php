<?php 
require_once('../require/db.php');

$arrayEdit = ['title' => null, 
'description' => null, 
'price' => null,
'count' => null];
if(isset($_GET['edit'])){
    $editId = $_GET['edit'];

    $queryEditProducts = mysqli_query($db, "SELECT * FROM `products` WHERE `id` = '$editId'");
    $resultEditProducts = mysqli_fetch_array($queryEditProducts);

    $arrayEdit = ['title' => $resultEditProducts['title'], 
    'description' => $resultEditProducts['description'], 
    'price' => $resultEditProducts['price'], 
    'count' => $resultEditProducts['count']];

    if(isset($_POST['submit'])){
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $count = $_POST['count'];

        $queryEditArticle = mysqli_query($db, "SELECT * FROM `products` WHERE `id` = '$editId'");
        $resultEditArticle = mysqli_fetch_array($queryEditArticle);

        
        $cover = $_FILES['cover']['name'];
        $target = "../img/products-cover/".$resultEditArticle['article']."/".basename($cover);


        if(!empty($cover)){
            if(move_uploaded_file($_FILES['cover']['tmp_name'], $target)) {
                $queryEditPhoto = mysqli_query($db, "UPDATE `products` SET  `cover` = '$cover' WHERE `id` = '$editId'");

            }else{
                echo "error";
            }
        }
            
        $queryEdit = mysqli_query($db, "UPDATE `products` SET 
        `title` = '$title', 
        `description` = '$description', 
        `price` = '$price', 
        `count` = '$count' WHERE `id` = '$editId'");
        
        header('Location: products.php');
        exit;
    }


}elseif(isset($_GET['delete'])){
    $deleteId = $_GET['delete'];

    $queryDelete = mysqli_query($db, "SELECT * FROM `products` WHERE `id` = '$deleteId'");
    $resultDelete = mysqli_fetch_array($queryDelete);

    $articleDelete = $resultDelete['article'];
    $coverDelete = $resultDelete['cover'];



    $structure = '../img/admin-photo/'.$articleDelete;
    unlink($structure.'/'.$coverDelete);
    rmdir($structure);

    $queryDelete = mysqli_query($db, "DELETE FROM `products` WHERE `id` = '$deleteId'");

    header('Location: products.php');
    exit;
}else{
    if(isset($_POST['submit'])){
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $count = $_POST['count'];


        $queryAddProductsId = mysqli_query($db, "SELECT * FROM `products` ORDER BY `id` DESC");
        $resultAddProductsId = mysqli_fetch_array($queryAddProductsId);


        if(!$resultAddProductsId['id']){
            $articleId = '0';
        }else{
            $articleId = $resultAddProductsId['id'];
        }
        $article = date('ymd').$articleId;

        
        // создание структуры папок

        $structure = '../img/products-cover/'.$article;

        if (!mkdir($structure, 0777, true)) {
            die('Не удалось создать директории...');
        }

  
    
        $cover = $_FILES['cover']['name'];
        $target = "../img/products-cover/".$article."/".basename($cover);

        if(!empty($cover)){

            if(move_uploaded_file($_FILES['cover']['tmp_name'], $target)) {
                $queryAddProducts = mysqli_query($db, "INSERT INTO `products` (`cover`, `title`, `description`, `price`, `count`, `article`) 
                VALUES ('$cover', '$title', '$description', '$price', '$count', '$article')") or die(mysqli_error($queryAddProducts));
            }else{
                echo "error";
            }
        }else{
            $queryAddProducts = mysqli_query($db, "INSERT INTO `products` (`title`, `description`, `price`, `count`, `article`) 
            VALUES ('$title', '$description', '$price', '$count', '$article')") or die(mysqli_error($queryAddProducts));

        }
   
     
        header('Location: products.php');
        exit;
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
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/statistics.css">
    <link rel="stylesheet" href="css/staff.css">
    <title>Document</title>
</head>
<body>
    <main>
        <?php require_once('include/menu.php'); ?>

        <section class="section">
            <div class="sectionTitle">
                <h2>Добавить товар</h2>
            </div>

            <div class="content">
                <form action="" class="formContainer" method="post" enctype="multipart/form-data">
                    <div class="formLeft">
                        <div class="formLeftPhoto">
                            <input class="file" type="file" onchange="loadFile(event)" id="filePhoto" name="cover">
                            <label for="filePhoto" id="image" class="filePhoto"><img id="output"/></label>
                            <input class="inputForm submit" type="submit" name="submit" value="Загрузить">

                        </div>

                        <div class="formLeftInput">
                            <input class="inputForm input" type="text" name="title" placeholder="Введите название" <?php edit('input', $arrayEdit['title']); ?>>
                        
                            <textarea class="inputForm textarea" name="description" placeholder="Введите описание"><?php edit('textarea', $arrayEdit['description']); ?></textarea>
                        </div>
                    </div>

                    <div class="formRight">
                        <input class="inputForm input" type="text" name="count" placeholder="Введите кол-во товара" <?php edit('input', $arrayEdit['count']); ?>>
                        <input class="inputForm input" type="text" name="price" placeholder="Введите цену товара" <?php edit('input', $arrayEdit['price']); ?>>
                    </div>
                </form>
            </div>

            <div class="sectionTitle">
                <h2>Все товары</h2>
            </div>

            <div class="content">
                <div class="staffContainer">
                    <?php $loginCookie = $_COOKIE['login'];
                    $queryProducts = mysqli_query($db, "SELECT * FROM `products` ORDER BY `id` DESC");
                    while ($rowProducts = mysqli_fetch_array($queryProducts)) { ?>
                        <div class="staff">
                            <div class="staffPhoto"><img src="../img/products-cover/<?php echo $rowProducts['article']."/".$rowProducts['cover']; ?>" alt=""></div>

                            <div class="staffInformation">
                                <h2><?php echo $rowProducts['title']; ?></h2>
                                <p><?php echo $rowProducts['price']." Руб."; ?></p>
                            </div>

                            <div class="staffAction">
                                <a class="staffActionEdit" href="products.php?edit=<?php echo $rowProducts['id']; ?>">Редактировать</a>
                                <a class="staffActionDelete" href="products.php?delete=<?php echo $rowProducts['id']; ?>">Удалить</a>
                            </div>
                        </div>
                    <?php }
                    
                    ?>
                </div>

                <div id="image">

                </div>
            </div>
        </section>
    </main>
    
    <script src="js/output.js"></script>
  
</body>
</html>