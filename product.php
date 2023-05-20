<?php 
include_once('include/header.php'); 
require_once('require/db.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $queryProduct = mysqli_query($db, "SELECT * FROM `products` WHERE `id` = '$id'");
    $resultProduct = mysqli_fetch_array($queryProduct);
}
?>

<link rel="stylesheet" href="css/product.css">

<section class="product">
    <div class="container">
        <div class="productContent">
            <div class="productImg">
                <img src="img/products-cover/<?php echo $resultProduct['article']."/".$resultProduct['cover']; ?>" alt="">
            </div>

            <div class="productInfo">
                <h2><?php echo $resultProduct['title']; ?></h2>
                <h3><?php echo $resultProduct['price']; ?> руб.</h3>

                <div class="productInfoDescription">
                    <p><?php echo $resultProduct['description']; ?></p>
                </div>

                <div class="productInfoBtnContainer">
                        <a href="#" class="btnBasket">
                            <img src="img/components/products/bask.png" alt="">
                            В корзину
                        </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="production">
    <div class="container">
        <div class="titleSection">
            <h2>Новые товары</h2>
        </div>

        <div class="productionContainer">
            <?php 
            $queryProduct = mysqli_query($db, "SELECT * FROM `products` ORDER BY id DESC LIMIT 5");
            while ($rowProduct = mysqli_fetch_array($queryProduct)) { ?>
                <div class="productBlock">
                    <div class="productBlockImg">
                        <img src="img/products-cover/<?php echo $rowProduct['article']; ?>/<?php echo $rowProduct['cover']; ?>" alt="">
                    </div>

                    <div class="productBlockInformation">
                        <h3><?php echo $rowProduct['title']; ?></h3>
                        <h2><?php echo $rowProduct['price']; ?> Руб.</h2>

                        <div class="InformationBtnContainer">
                            <a href="product.php?id=<?php echo $rowProduct['id']; ?>" class="informationBtn">
                                <p>Перейти</p>
                            </a>
                        </div>
                    </div>
                </div>
            <?php }
            ?>
        </div>
    </div>
</section>

<?php include_once('include/footer.php'); ?>