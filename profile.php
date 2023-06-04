<?php 
include_once('include/header.php'); 

if(!$resultClient){
    header('Location: login.php');
    exit;
}

if(isset($_GET['cancel'])){
    $idCancel = $_GET['cancel'];

    $queryUpdate = mysqli_query($db, "UPDATE `cheque` SET `status` = '0' WHERE `id` = '$idCancel'");
    header('Location: profile.php');
}

$queryProfile = mysqli_query($db, "SELECT * FROM `clients` WHERE `telephone` = '$cookieTelephone'");
$resultProfile = mysqli_fetch_array($queryProfile);


if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $queryEditStaffPhoto = mysqli_query($db, "UPDATE `clients` SET  `name` = '$name', `telephone` = '$telephone', `email` = '$email',  `password` = '$password' WHERE `telephone` = '$cookieTelephone'");

    setcookie('password', $password);

    header('Location: profile.php');
}


?>

<link rel="stylesheet" href="css/profile.css">

<section class="profile">
    <div class="container">
        <div class="content">
            <div class="profileContent">
                <div class="center">
                    <div class="formContainer">
                        <h2>Редактировать профиль</h2>
                    </div>
                </div>
                
                <form action="" class="formProfile" method="post">
                    <input type="text" name="name" placeholder="Введите имя" value="<?php echo $resultProfile['name']; ?>" required>
                    <input type="text" name="telephone"  class="tel"  placeholder="Введите телефон" value="<?php echo $resultProfile['telephone']; ?>" required>
                    <input type="mail" name="email" placeholder="Введите Email" value="<?php echo $resultProfile['email']; ?>" required>
                    <input type="password" name="password" placeholder="Введите пароль" required>

                    <div class="formContainer">
                        <input type="submit" name="submit" value="Сохранить">
                        <a href="logout.php">Выход</a>
                    </div>
                </form>

                <div class="center">
                    <div class="formContainer">
                        <h2>Записи</h2>
                    </div>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Услуга</th>
                            <th>Барбер</th>
                            <th>Дата визита</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $statusArray = [0 => "Отменен", 1 => "Ожидает", 2 => "Посещен"];
                        $statusColor = [0 => "#ff0000", 1 => "#4f4fff", 2 => "#77AD9D"];

                        $queryRowCheque = mysqli_query($db, "SELECT * FROM `cheque` LEFT JOIN `cheque_info` ON cheque.id = cheque_info.id_cheque WHERE cheque.client = '$cookieTelephone' AND cheque_info.id_product is null ORDER BY cheque.id DESC");
                        while ($rowCheque = mysqli_fetch_array($queryRowCheque)) {
                            $idService = $rowCheque['id_service'];
                            $loginStaff = $rowCheque['staff'];
                            
                            $queryService = mysqli_query($db, "SELECT * FROM `services` WHERE `id` = '$idService'");
                            $resultService = mysqli_fetch_array($queryService);

                            $queryStaff = mysqli_query($db, "SELECT * FROM `staff` WHERE `login` = '$loginStaff'");
                            $resultStaff = mysqli_fetch_array($queryStaff);
                            
                            if(empty($rowCheque['datetime'])){
                                $tableDatetime = '';
                            }else{
                                $tableDatetime = $rowCheque['datetime'];
                            }
                            ?>
                            <tr>
                                <td><?php echo $resultService['title']; ?></td>
                                <td><?php echo $resultStaff['name']; ?></td>
                                <td><?php echo $tableDatetime; ?></td>
                                <td><div style="background: <?php echo $statusColor[$rowCheque['status']]; ?>;" class="status"><p><?php echo $statusArray[$rowCheque['status']]; ?></p></div></td>
                                <td><?php
                                if($rowCheque['status'] == 1){ ?>
                                    <a href="profile.php?cancel=<?php echo $rowCheque['id_cheque']; ?>">Отменить</a>
                                <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>



<?php include_once('include/footer.php'); ?>