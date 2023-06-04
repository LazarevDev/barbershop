<?php 
include_once('include/header.php'); 
require_once('require/db.php');

?>

<link rel="stylesheet" href="css/production.css">

<section class="sectionPage">
    <div class="container">
        <div class="titleSection">
            <h2>Наша продукция</h2>
            <p>Мы создаем стильные мужские прически. <br> 
                Познакомьтесь с нашими услугами подробнее:</p>
        </div>

        <div class="productionContainer">
            <?php 
            $queryProduct = mysqli_query($db, "SELECT * FROM `products` ORDER BY id DESC");
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
            <?php } ?>
        </div>
    </div>
</section>

<?php include_once('include/footer.php'); ?>