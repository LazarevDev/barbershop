<?php 
require_once('../require/db.php');
require_once('require-panel/cookie.php');

if(isset($_GET['pagination'])){
    $pagination = $_GET['pagination'];
}else $pagination = 1;

$paginationCount = 10;  //количество записей для вывода
$paginationMin = ($pagination * $paginationCount) - $paginationCount; // определяем, с какой записи нам выводить
 

$resCount = mysqli_query($db, "SELECT COUNT(*) FROM `clients`");
$rowCount = mysqli_fetch_row($resCount);
$total = $rowCount[0]; // всего записей	

$stePagination = ceil($total / $paginationCount);

$idPage = null;
require_once('require-panel/pagination.php');
  

if(isset($_GET['delete'])){
    $deleteId = $_GET['delete'];

    $queryDelete = mysqli_query($db, "DELETE FROM `clients` WHERE `id` = '$deleteId'");

    header('Location: clients.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/clients.css">
    <title>Document</title>
</head>
<body>
    <main>
        <?php require_once('include/menu.php'); ?>

        <section class="section">
            <div class="sectionTitle">
                <h2>Клиенты</h2>
            </div>

            <div class="content">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Имя</th>
                            <th>Тел</th>
                            <th>Email</th>
                            <th>Дата последнего визита</th>
                            <th>Дата регистрации</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        $queryRowClients = mysqli_query($db, "SELECT * FROM `clients` ORDER BY `id` DESC LIMIT $paginationMin,$paginationCount");
                        while ($rowClients = mysqli_fetch_array($queryRowClients)) {
                            $rowClient = $rowClients['telephone'];
                            $queryCheque = mysqli_query($db, "SELECT * FROM `cheque` LEFT JOIN `cheque_info` ON cheque.id = cheque_info.id_cheque WHERE cheque.client = '$rowClient' AND cheque_info.id_product is null ORDER BY cheque.id DESC");
                            $resultCheque = mysqli_fetch_array($queryCheque);

                            if(empty($resultCheque['datetime'])){
                                $tableDatetime = '';
                            }else{
                                $tableDatetime = $resultCheque['datetime'];
                            }
                            ?>
                            <tr>
                                <td><?php echo $rowClients['name']; ?></td>
                                <td><?php echo $rowClients['telephone']; ?></td>
                                <td><?php echo $rowClients['email']; ?></td>
                                <td><?php echo $tableDatetime; ?></td>
                                <td><?php echo $rowClients['date']; ?></td>
                                <td><a href="clients.php?delete=<?php echo $rowClients['id']; ?>">Удалить</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <?php paginationOutput($stePagination, $idPage); ?>

            </div>
        </section>
    </main>
    
    <script src="js/output.js"></script>
  
</body>
</html>