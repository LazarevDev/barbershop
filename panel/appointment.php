<?php 
require_once('../require/db.php');
require_once('require-panel/cookie.php');

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
    <title>Document</title>
</head>
<body>
    <main>
        <?php require_once('include/menu.php'); ?>

        <section class="section">
            <div class="sectionTitle">
                <h2>Записи</h2>
            </div>

            <div class="content">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Имя</th>
                            <th>Тел</th>
                            <th>Email</th>
                            <th>Барбер</th>
                            <th>Услуга</th>
                            <th>Стоимость</th>
                            <th>Дата визита</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        $queryRowCheque = mysqli_query($db, "SELECT * FROM `cheque` RIGHT JOIN `cheque_info` ON cheque.id = cheque_info.id_cheque WHERE cheque_info.id_product is null ORDER BY cheque.id DESC");
                        while ($rowCheque = mysqli_fetch_array($queryRowCheque)) {
                            $rowClient = $rowCheque['client'];
                            $rowStaff = $rowCheque['staff'];
                            $rowService = $rowCheque['id_service'];

                            $queryClient = mysqli_query($db, "SELECT * FROM `clients` WHERE `telephone` = '$rowClient'");
                            $resultClient = mysqli_fetch_array($queryClient);

                            $queryStaff = mysqli_query($db, "SELECT * FROM `staff` WHERE `login` = '$rowStaff'");
                            $resultStaff = mysqli_fetch_array($queryStaff);

                            $queryService = mysqli_query($db, "SELECT * FROM `services` WHERE `id` = '$rowService'");
                            $resultService = mysqli_fetch_array($queryService);

                            $statusArray = [0 => "Отменен", 1 => "Зарегистрирован", 2 => "Принят"];
                            
                            if($resultClient && $resultStaff){ ?>
                                <tr>
                                    <td><?php echo $resultClient['name']; ?></td>
                                    <td><?php echo $resultClient['telephone']; ?></td>
                                    <td><?php echo $resultClient['email']; ?></td>
                                    <td><?php echo $resultStaff['name']; ?></td>
                                    <td><?php echo $resultService['title']; ?></td>
                                    <td><?php echo $resultService['price']; ?> Руб.</td>
                                    <td><?php echo $rowCheque['datetime']; ?></td>
                                    <td><div class="status"><p><?php echo $statusArray[$rowCheque['status']]; ?></p></div></td>
                                    <td><a href="" style="color: blue">Подтвердить</a><a href="">Отменить</a></td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>

            </div>
        </section>
    </main>
    
    <script src="js/output.js"></script>
  
</body>
</html>