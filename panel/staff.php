<?php 
require_once('../require/db.php');



if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $login = $_POST['login'];
    $specialization = $_POST['specialization'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $description = $_POST['description'];
    $salary = $_POST['salary'];
    $perecent = $_POST['perecent'];
    $photo = $_POST['photo'];
    $password = md5($_POST['password']);


            
    $queryAddStaff = "INSERT INTO `staff` (`name`, `login`, `specialization`, `telephone`, `email`, `description`,`salary`, `perecent`, `password`) VALUES 
    ('$name', '$login', '$specialization', '$telephone', '$email', '$description', '$salary', '$perecent', '$password')";
    
    $resultAddStaff = mysqli_query($db, $queryAddStaff) or die(mysqli_error($db));


}
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
                <h2>Добавить сотрудника</h2>
            </div>

            <div class="content">
                <form action="" class="formContainer" method="post">
                    <div class="formLeft">
                        <div class="formLeftPhoto">
                            <input class="file" type="file" id="filePhoto" name="photo">
                            <label for="filePhoto" class="filePhoto"></label>

                            <input class="inputForm submit" type="submit" name="submit" value="Загрузить">

                        </div>

                        <div class="formLeftInput">
                            <input class="inputForm input" type="text" name="name" placeholder="Введите имя">
                            <input class="inputForm input" type="text" name="login" placeholder="Введите логин">
                        
                            <select class="inputForm select" name="specialization" id="">
                                <option value="0">Младший барбер</option>
                                <option value="1">Старший барбер</option>
                                <option value="2">Администратор</option>
                            </select>

                            <textarea class="inputForm textarea" name="description" placeholder="Введите описание"></textarea>
                        </div>
                    </div>

                    <div class="formRight">
                        <input class="inputForm input" type="text" name="telephone" placeholder="Введите телефон">
                        <input class="inputForm input" type="email" name="email" placeholder="Введите email">
                        <input class="inputForm input" type="text" name="salary" placeholder="Оклад">
                        <input class="inputForm input" type="text" name="perecent" placeholder="Процент с услуг">
                        <input class="inputForm input" type="password" name="password" placeholder="Введите пароль">
                    </div>
                </form>
            </div>

            <div class="sectionTitle">
                <h2>Все сотрудники</h2>
            </div>

            <div class="content">
                <div class="staffContainer">
                    <?php 
                    $queryStaff = mysqli_query($db, "SELECT * FROM `staff`");
                    while ($rowStaff = mysqli_fetch_array($queryStaff)) { ?>
                        <div class="staff">
                            <div class="staffPhoto"></div>

                            <div class="staffInformation">
                                <h2><?php echo $rowStaff['name']; ?></h2>
                                <p><?php if($rowStaff['specialization'] == '0'){ echo "Младший брабер"; }elseif($rowStaff['specialization'] == '1'){ echo "Старший барбер"; }elseif($rowStaff['specialization'] == '2'){ echo "Администратор"; }?></p>
                            </div>

                            <div class="staffAction">
                                <a class="staffActionEdit" href="">Редактировать</a>
                                <a class="staffActionDelete" href="">Удалить</a>
                            </div>
                        </div>
                    <?php }
                    
                    ?>
                </div>
            </div>
        </section>
    </main>
</body>
</html>