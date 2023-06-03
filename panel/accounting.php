<?php 
require_once('../require/db.php');
require_once('require-panel/cookie.php');
require_once('require-panel/pagination.php');



if(isset($_GET['page'])){
    $idPage = $_GET['page'];

    if($idPage == 1){
        // Вывод всех отзывов
        $status = 'status';
        $titlePage = "Все записи";
    }elseif($idPage == 2){
        // Вывод ожидания
        $status = '1';
        $titlePage = "Зарегистрированные";
    }elseif($idPage == 3){
        // Вывод одобренных
        $status = '2';
        $titlePage = "Оплаченные";
    }elseif($idPage == 4){
        // Вывод отклоненных
        $status = '0';
        $titlePage = "Отмененные";
    }
}else{
    header('Location: accounting.php?page=1');
    exit;
}


if(isset($_GET['pagination'])){
    $pagination = $_GET['pagination'];
}else $pagination = 1;

$paginationCount = 10;  //количество записей для вывода
$paginationMin = ($pagination * $paginationCount) - $paginationCount; // определяем, с какой записи нам выводить
 

$resCount = mysqli_query($db, "SELECT COUNT(*) FROM `cheque` RIGHT JOIN `cheque_info` ON cheque.id = cheque_info.id_cheque WHERE cheque_info.id_service is null AND cheque.status = $status ORDER BY cheque.id DESC");
$rowCount = mysqli_fetch_row($resCount);
$total = $rowCount[0]; // всего записей	

$stePagination = ceil($total / $paginationCount);



  

// confirm

if(isset($_GET['confirm']) and isset($_GET['page'])){
    $idPage = $_GET['page'];
    $idConfirm = $_GET['confirm'];

    $queryUpdate = mysqli_query($db, "UPDATE `cheque` SET `status` = '2' WHERE `id` = '$idConfirm'");

    echo $idConfirm;

    header('Location: accounting.php?page='.$idPage);
}


// cancel

if(isset($_GET['cancel']) and isset($_GET['page'])){
    $idPage = $_GET['page'];
    $idCancel = $_GET['cancel'];

    $queryUpdate = mysqli_query($db, "UPDATE `cheque` SET `status` = '0' WHERE `id` = '$idCancel'");
    header('Location: accounting.php?page='.$idPage);
}


function accounting($db, $status, $idPage, $paginationMin, $paginationCount){
    
    $queryRowCheque = mysqli_query($db, "SELECT * FROM `cheque_info` LEFT JOIN `cheque` ON cheque.id = cheque_info.id_cheque WHERE cheque_info.id_service is null AND cheque.status = $status ORDER BY cheque.id DESC LIMIT $paginationMin,$paginationCount");
    while ($rowCheque = mysqli_fetch_array($queryRowCheque)) {
        $rowClient = $rowCheque['client'];
        $rowProduct = $rowCheque['id_product'];

        $queryClient = mysqli_query($db, "SELECT * FROM `clients` WHERE `telephone` = '$rowClient'");
        $resultClient = mysqli_fetch_array($queryClient);

        $queryProduct = mysqli_query($db, "SELECT * FROM `products` WHERE `id` = '$rowProduct'");
        $resultProduct = mysqli_fetch_array($queryProduct);

        $statusArray = [0 => "Отменен", 1 => "Ожидает", 2 => "Выдан"];
        $statusColor = [0 => "#ff0000", 1 => "#4f4fff", 2 => "#77AD9D"];
        ?>
            <tr>
                <td><?php echo $resultClient['name']; ?></td>
                <td><?php echo $resultClient['telephone']; ?></td>
                <td><?php echo $resultClient['email']; ?></td>
                <td><?php echo $resultProduct['title']; ?></td>
                <td><?php echo $resultProduct['article']; ?></td>
                <td><?php echo $resultProduct['price']; ?> Руб.</td>
                <td><?php echo $rowCheque['datetime']; ?></td>
                <td><div style="background: <?php echo $statusColor[$rowCheque['status']]; ?>;" class="status"><p><?php echo $statusArray[$rowCheque['status']]; ?></p></div></td>
                <td><?php
                if($rowCheque['status'] == 2){ ?>
                    <a href="accounting.php?page=<?php echo $idPage; ?>&cancel=<?php echo $rowCheque['id_cheque']; ?>">Отменить</a>

                <?php }elseif($rowCheque['status'] == 0){ ?>
                    <a href="accounting.php?page=<?php echo $idPage; ?>&confirm=<?php echo $rowCheque['id_cheque']; ?>" style="color: blue">Выдать</a>
                <?php }else{?>
                    <a href="accounting.php?page=<?php echo $idPage; ?>&confirm=<?php echo $rowCheque['id_cheque']; ?>" style="color: blue">Выдать</a>
                    <a href="accounting.php?page=<?php echo $idPage; ?>&cancel=<?php echo $rowCheque['id_cheque']; ?>">Отменить</a>


                <?php } ?>
                </td>
            </tr>
    <?php }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <title>Document</title>
</head>
<body>
    <main>
        <?php require_once('include/menu.php'); ?>

        <section class="section">
            <div class="sectionTitle">
                <h2><?php echo $titlePage; ?></h2>
            </div>

            <div class="sectionContainerBtn">
                    <a href="accounting.php?page=1" class="sectionBtn">Все записи</a>
                    <a href="accounting.php?page=2" class="sectionBtn">Зарегистрированные</a>
                    <a href="accounting.php?page=3" class="sectionBtn">Оплаченные</a>
                    <a href="accounting.php?page=4" class="sectionBtn">Отмененные</a>
                </div>


            <div class="content">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Имя</th>
                            <th>Тел</th>
                            <th>Email</th>
                            <th>Товар</th>
                            <th>Артикул</th>
                            <th>Стоимость</th>
                            <th>Дата заказа</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php accounting($db, $status, $idPage, $paginationMin, $paginationCount); ?>
                        
                    </tbody>
                </table>

                <?php paginationOutput($stePagination, $idPage); ?>
            </div>
        </section>
    </main>
    
    <script src="js/output.js"></script>
  
</body>
</html>