<?php 
include_once('include/header.php'); 
?>
<link rel="stylesheet" href="css/index.css">
<link rel="stylesheet" href="css/hystmodal.min.css">
<script src="js/hystmodal.min.js"></script>

<section class="home">
    <div class="container">
        <div class="homeContent">
            <h2>Место для настоящих <span>мужчин</span></h2>
            <p>Запишись на первую стрижку в барбершоп - <span class="spanUppercase">Со скидкой 20%</span></p>

            <div class="homeBtnContainer">
                <a data-hystmodal="#myModal" class="btnGreen homeBtn" href="">Онлайн запись</a> <p>*акция действует на первое посещение. <br> На товары данная акция не распространяется.</p>
            </div>
        </div>

        <div class="advantagesContent">
            <div class="advantagesBlock">
                <div class="advantagesBlockImg">
                    <img src="img/components/home/scissors.png" alt="">
                </div>

                <div class="advantagesBlockText">
                    <h3>Мы - профессионалы</h3>
                    <p>Мы знаем, что вам нужно. И сделаем это на высшем уровне</p>
                </div>
            </div>

            <div class="advantagesBlock">
                <div class="advantagesBlockImg">
                    <img src="img/components/home/chair.png" alt="">
                </div>

                <div class="advantagesBlockText">
                    <h3>С нами удобно</h3>
                    <p>Обладаем хорошей транспортной доступностью со всего города</p>
                </div>
            </div>

            <div class="advantagesBlock">
                <div class="advantagesBlockImg">
                    <img src="img/components/home/barbershop.png" alt="">
                </div>

                <div class="advantagesBlockText">
                    <h3>Предлагаем только лучшее</h3>
                    <p>Для Вас лучшие барберы, лучшая косметика, лучший кофе</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about">
    <div class="container">
        <div class="titleSection">
            <h2>О нас</h2>
        </div>
        
        <div class="aboutContent">
            <div class="aboutText">
                <p>Eu cum iuvaret debitis voluptatibus, esse perfecto reformidans id has. Vivendum dignissim conceptam pri ut, ei vel partem audiam sapientem. Eu cum iuvaret debitis voluptatibus, esse perfecto reformidans id has. </p>
                <p>Eu cum iuvaret debitis voluptatibus, esse perfecto reformidans id has. Vivendum dignissim conceptam pri ut, ei vel partem audiam sapientem. Eu cum iuvaret debitis voluptatibus, esse perfecto reformidans id has. </p>
                <p>Eu cum iuvaret debitis voluptatibus, esse perfecto reformidans id has. Vivendum dignissim conceptam pri ut, ei vel partem audiam sapientem. Eu cum iuvaret debitis voluptatibus, esse perfecto reformidans id has. </p>
            </div>

            <div class="aboutImg">
                <img src="img/components/about/bg.png" alt="">
            </div>
        </div>
    </div>
</section>

<section class="services">
    <div class="container">
        <div class="titleSection">
            <h2>Популярные услуги</h2>
            <p>Мы создаем стильные мужские прически. <br> 
                Познакомьтесь с нашими услугами подробнее:</p>
        </div>

        <div class="servicesContent">
            <?php 
            $serviceQuery = mysqli_query($db, "SELECT * FROM `services` ORDER BY id DESC");
            while ($rowService = mysqli_fetch_array($serviceQuery)) { 
                ?>
                <div class="serviceBlock">
                    <div class="serviceBlockTitle">
                        <p><?php echo $rowService['reception_time']; ?> минут</p>
                        <h3><?php echo $rowService['title']; ?></h3>
                    </div>

                    <div class="serviceBlockPrice">
                        <p><?php echo $rowService['price']; ?> руб.</p>
                    </div>
                </div>
            <?php }
            ?>
        </div>

        <div class="serviceBtnContainer">
            <a data-hystmodal="#myModal" href="" class="btnGreen">Записаться сейчас</a>
        </div>
    </div>
</section>

<section class="production">
    <div class="container">
        <div class="titleSection">
            <h2>Наша продукция</h2>
            <p>Мы создаем стильные мужские прически. <br> 
                Познакомьтесь с нашими услугами подробнее:</p>
        </div>

        <div class="productionContainer">
            <?php 
            $queryProduct = mysqli_query($db, "SELECT * FROM `products` ORDER BY id DESC LIMIT 4");
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

        <div class="productionBtnContainer">
            <a href="#" class="btnDark">Смотреть все</a>
        </div>
    </div>
</section>

<section class="staff">
    <div class="container">
        <div class="titleSection">
            <h2>Наши сотрудники</h2>
        </div>

        <div class="staffContainer">
            <?php 
            $queryStaff = mysqli_query($db, "SELECT * FROM `staff` WHERE `specialization` != '2' AND RAND() LIMIT 4");
            while ($rowStaff = mysqli_fetch_array($queryStaff)) { ?>
                <a href="employee.php?id=<?php echo $rowStaff['id']; ?>" class="staffBlock">
                    <div class="staffImg"><img src="img/admin-photo/<?php echo $rowStaff['login']."/".$rowStaff['photo']; ?>" alt=""></div>
                    <div class="staffName"><h2><?php echo $rowStaff['name']; ?></h2></div>
                </a>
            <?php } ?>
        </div>
    </div>
</section>


<!-- modal -->

<link rel="stylesheet" href="css/ajax-content.css">

<div class="hystmodal" id="myModal" aria-hidden="true">
   <div class="hystmodal__wrap">
        <div class="hystmodal__windows" role="dialog" aria-modal="true">
         <button data-hystclose class="hystmodal__close">Закрыть</button>
            <div class="hystmodalBlock">
                <div id="content">
                    <h2>Выберите услугу</h2>

                    <div class="modalContainer">
                        <?php $queryServiceCategory = mysqli_query($db, "SELECT DISTINCT category FROM `services`");
                        while($rowCategory = mysqli_fetch_array($queryServiceCategory)){
                            $category = $rowCategory['category']; ?>
                            <div class="modalBlock">
                                <div class="servicesCategoryTitle">
                                    <h2><?php echo $category; ?></h2>
                                </div>

                                <?php $queryService = mysqli_query($db, "SELECT * FROM `services` WHERE `category` = '$category'");
                                while($rowService = mysqli_fetch_array($queryService)){ ?>
                                    <div class="servicesBlock">
                                        <a href="<?php echo $rowService['id']; ?>" class="serviceBtn"><?php echo $rowService['title']; ?> - <?php echo $rowService['price']; ?> руб.</a>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <?php require_once('ajax-require/ajax-service.php'); ?>
            </div>
        </div>
   </div>
</div>


<script>
    const myModal = new HystModal({
    linkAttributeName: "data-hystmodal",
    // настройки (не обязательно), см. API
});
</script>
<?php include_once('include/footer.php'); ?>