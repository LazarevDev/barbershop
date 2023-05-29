<?php 
include_once('include/header.php'); 


if(!$resultClient){
    header('Location: login.php');
    exit;
}

if(isset($_GET['add'])){
    $add = $_GET['add'];

    $queryBasketId = mysqli_query($db, "SELECT * FROM `basket` WHERE `id_product` = '$add'");
    $resultBasketId = mysqli_fetch_array($queryBasketId);

    if(!$resultBasketId){
        $queryAddBasket = mysqli_query($db, "INSERT INTO `basket` (`client`, `id_product`) VALUES ('$cookieTelephone', '$add')");
    }else{
        $queryUpdateBasketCount = mysqli_query($db, "UPDATE `basket` SET `count_basket` = `count_basket` + '1' WHERE `id_product` = '$add'");
    }

    header('Location: basket.php');
}

if(isset($_GET['delete'])){
    $delete = $_GET['delete'];

    $queryDeleteBasketId = mysqli_query($db, "DELETE FROM `basket` WHERE `id_product` = '$delete' AND `client` = '$cookieTelephone'");
}

if(isset($_POST['submit'])){
    $count = $_POST['count'];

    $queryCheque = mysqli_query($db, "SELECT * FROM `cheque` ORDER BY `id` DESC");
    $resultQueryCheque = mysqli_fetch_array($queryCheque);

    if(empty($resultQueryCheque['id'])){
        $idCheque = '0';
    }else{
        $idCheque = $resultQueryCheque['id'];
    }

    $idCheque += 1;
    $date = date('Y-m-d H:i:s');
    $title = $idCheque."-".$date;

    $queryAddCheque = mysqli_query($db, "INSERT INTO `cheque` (`title`, `client`, `datetime`) VALUES ('$title', '$cookieTelephone', '$date')");



    $queryBasket = mysqli_query($db, "SELECT * FROM `basket` WHERE `client` = '$cookieTelephone'");
    while($row = mysqli_fetch_array($queryBasket)){
        $idProduct = $row['id_product'];

        $queryAddChequeInfo = mysqli_query($db, "INSERT INTO `cheque_info` (`id_product`, `count`, `id_cheque`) VALUES ('$idProduct', '$count', '$idCheque')");

    }


    $queryDeleteBasket = mysqli_query($db, "DELETE FROM `basket` WHERE `client` = '$cookieTelephone'");

    // profile.php
    header('Location: index.php');
    exit;



}

$queryCountProducts = mysqli_query($db, "SELECT COUNT(*) `id` FROM `basket` WHERE `client` = '$cookieTelephone'");
$resultCountProducts = mysqli_fetch_array($queryCountProducts);

$queryPriceProducts = mysqli_query($db, "SELECT SUM(`price`) price, SUM(`count_basket`) count_basket FROM `basket` LEFT JOIN `products` ON products.id = basket.id_product WHERE basket.client = '$cookieTelephone'");
$resultPriceProducts = mysqli_fetch_array($queryPriceProducts);

?>

<link rel="stylesheet" href="css/basket.css">

<form method="post" class="basket">
    <div class="container">
        <div class="basketContainer">
            <div class="basketContent">
                <div class="basketTable">
                    <?php 
                    $queryBasketTable = mysqli_query($db, "SELECT * FROM `basket` LEFT JOIN `products` ON products.id = basket.id_product WHERE basket.client = '$cookieTelephone'");
                    while ($row = mysqli_fetch_array($queryBasketTable)) { ?>
                        <div class="basketProductBlock">
                            <div class="productBlockInfo">
                                <a href="product.php?id=<?php echo $row['id_product']; ?>" class="productBlockImg">
                                    <img src="img/products-cover/<?php echo $row['article']."/".$row['cover']; ?>" alt="">
                                </a>

                                <div class="productBlockText">
                                    <h2><?php echo $row['title']; ?></h2>
                                    <p>Артикул: <?php echo $row['article']; ?></p>
                                    <h3>Цена: <?php echo $row['price']; ?> Руб.</h3>

                                    <form action="" method="post">
                                        <label class="countLabel" for="">
                                            <p>Кол-во: </p>
                                            <input type="number" name="count" min="0" max="<?php echo $row['count']; ?>" value="<?php echo $row['count_basket']; ?>">
                                        </label>
                                    </form>
                                </div>
                            </div>
                            <div class="productBlockAction">
                                <a href="basket.php?delete=<?php echo $row['id']; ?>">Удалить из корзины</a>
                            </div>
                        </div>
                    <?php }
                    ?>    

                    
                </div>
            </div>

            <div class="basketInfoContent">
                <div class="basketInfo">
                    <div class="basketInfoTitle">
                        <h2>Ваша корзина:</h2>
                    </div>

                    <div class="basketInfoText">
                        <p>Кол-во товара: <?php echo $resultPriceProducts['count_basket']; ?></p>
                        <p>На сумму: <?php if($resultPriceProducts['price']){ echo $resultPriceProducts['count_basket'] * $resultPriceProducts['price']; }else{ echo "0"; } ?> Руб.</p>
                    </div>

                    <div class="basketBtnContainer">
                        <input type="submit" name="submit" class="basketBtn" value="Оформить заказ">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>



<?php include_once('include/footer.php'); ?>