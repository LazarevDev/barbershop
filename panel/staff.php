<?php 
require_once('../require/db.php');



$arrayEdit = ['name' => null, 
'login' => null, 
'specialization' => null, 
'telephone' => null,
'email' => null, 
'description' => null, 
'salary' => null,
'perecent' => null,
'password' => null];

if(isset($_GET['edit'])){
    $editId = $_GET['edit'];

    $queryEditStaff = mysqli_query($db, "SELECT * FROM `staff` WHERE `id` = '$editId'");
    $resultEditStaff = mysqli_fetch_array($queryEditStaff);

    $arrayEdit = ['name' => $resultEditStaff['name'], 
    'login' => $resultEditStaff['login'], 
    'specialization' => $resultEditStaff['specialization'], 
    'telephone' => $resultEditStaff['telephone'],
    'email' => $resultEditStaff['email'], 
    'description' => $resultEditStaff['description'], 
    'salary' => $resultEditStaff['salary'],
    'perecent' => $resultEditStaff['perecent'],
    'password' => $resultEditStaff['password']];

    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $login = $_POST['login'];
        $specialization = $_POST['specialization'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];
        $description = $_POST['description'];
        $salary = $_POST['salary'];
        $perecent = $_POST['perecent'];



        $queryEditLogin = mysqli_query($db, "SELECT * FROM `staff` WHERE `id` = '$editId'");
        $resultEditLogin = mysqli_fetch_array($queryEditLogin);

        if(empty($_POST['password'])){
            $password = $resultEditLogin['password'];
        }else{
            $password = md5($_POST['password']);
        }


        
        $photo = $_FILES['photo']['name'];
        $target = "../img/admin-photo/".$resultEditLogin['login']."/".basename($photo);

        if(!empty($photo)){
            if(move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
                $queryEditStaffPhoto = mysqli_query($db, "UPDATE `staff` SET  `photo` = '$photo' WHERE `id` = '$editId'");

            }else{
                echo "error";
            }
        }
            
     
        $queryEditStaff = mysqli_query($db, "UPDATE `staff` SET 
        `name` = '$name', 
        `login` = '$login', 
        `specialization` = '$specialization', 
        `telephone` = '$telephone', 
        `email` = '$email',
        `description` = '$description', 
        `salary` = '$salary', 
        `perecent` = '$perecent',
        `password` = '$password' WHERE `id` = '$editId'");
        
        header('Location: staff.php');
        exit;
    }


}elseif(isset($_GET['delete'])){
    $deleteId = $_GET['delete'];

    $queryEditLogin = mysqli_query($db, "SELECT * FROM `staff` WHERE `id` = '$deleteId'");
    $resultEditLogin = mysqli_fetch_array($queryEditLogin);

    $loginDelete = $resultEditLogin['login'];
    $photoDelete = $resultEditLogin['photo'];



    $structure = '../img/admin-photo/'.$loginDelete;
    unlink($structure.'/'.$photoDelete);
    rmdir($structure);

    $queryDelete = mysqli_query($db, "DELETE FROM `staff` WHERE `id` = '$deleteId'");

    header('Location: staff.php');
    exit;
}else{
    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $login = $_POST['login'];
        $specialization = $_POST['specialization'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];
        $description = $_POST['description'];
        $salary = $_POST['salary'];
        $perecent = $_POST['perecent'];
        $password = md5($_POST['password']);

        // создание структуры папок

        $structure = '../img/admin-photo/'.$login;

        if (!mkdir($structure, 0777, true)) {
            die('Не удалось создать директории...');
        }

    
   
        $photo = $_FILES['photo']['name'];
        $target = "../img/admin-photo/".$login."/".basename($photo);

        if(!empty($photo)){

            if(move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
                $queryAddStaff = mysqli_query($db, "INSERT INTO `staff` (`photo`, `name`, `login`, `specialization`, `telephone`, `email`, `description`, `salary`, `perecent`, `password`) VALUES 
                ('$photo', '$name', '$login', '$specialization', '$telephone', '$email', '$description', '$salary', '$perecent', '$password')");
                      
                // $resultAddStaff = mysqli_query($db, $queryAddStaffPhoto) or die(mysqli_error($db));
            }else{
                echo "error";
            }
        }else{
            $queryAddStaff = mysqli_query($db, "INSERT INTO `staff` (`name`, `login`, `specialization`, `telephone`, `email`, `description`, `salary`, `perecent`, `password`) VALUES 
            ('$name', '$login', '$specialization', '$telephone', '$email', '$description', '$salary', '$perecent', '$password')");
                  
        }

     
        header('Location: staff.php');
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
                <h2>Добавить сотрудника</h2>
            </div>

            <div class="content">
                <form action="" class="formContainer" method="post" enctype="multipart/form-data">
                    <div class="formLeft">
                        <div class="formLeftPhoto">
                            <input class="file" type="file" onchange="loadFile(event)" id="filePhoto" name="photo">
                            <label for="filePhoto" id="image" class="filePhoto"><img <?php if(isset($_GET['edit'])){ echo "src='../img/admin-photo/".$resultEditStaff['login']."/".$resultEditStaff['photo']."'"; } ?> id="output"/></label>
                            <input class="inputForm submit" type="submit" name="submit" value="Загрузить">
                            <?php 
                            if(isset($_GET['edit'])){?>
                                <a href="staff.php">Отменить</a>
                            <?php } ?>
                        </div>

                        <div class="formLeftInput">
                            <input class="inputForm input" type="text" name="name" placeholder="Введите имя" <?php edit('input', $arrayEdit['name']); ?> required>
                            <input class="inputForm input" type="text" name="login" placeholder="Введите логин" <?php edit('input', $arrayEdit['login']); ?> required>
                        
                            <select class="inputForm select" name="specialization" required id="" <?php edit('input', $arrayEdit['specialization']); ?>>
                                <option selected="true" disabled="disabled">Специальность</option>

                                <option value="0">Младший барбер</option>
                                <option value="1">Старший барбер</option>
                                <option value="2">Администратор</option>
                            </select>

                            <textarea class="inputForm textarea" name="description" placeholder="Введите описание"><?php edit('textarea', $arrayEdit['description']); ?></textarea>
                        </div>
                    </div>

                    <div class="formRight">
                        <input class="inputForm input" type="text" name="telephone" placeholder="Введите телефон" <?php edit('input', $arrayEdit['telephone']); ?>>
                        <input class="inputForm input" type="email" name="email" placeholder="Введите email" <?php edit('input', $arrayEdit['email']); ?>>
                        <input class="inputForm input" type="text" name="salary" placeholder="Оклад" <?php edit('input', $arrayEdit['salary']); ?>>
                        <input class="inputForm input" type="text" name="perecent" placeholder="Процент с услуг" <?php edit('input', $arrayEdit['perecent']); ?>>
                        <input class="inputForm input" type="password" name="password" placeholder="Введите пароль">
                    </div>
                </form>
            </div>

            <div class="sectionTitle">
                <h2>Все сотрудники</h2>
            </div>

            <div class="content">
                <div class="staffContainer">
                    <?php $loginCookie = $_COOKIE['login'];
                    $queryStaff = mysqli_query($db, "SELECT * FROM `staff` ORDER BY `id` DESC");
                    while ($rowStaff = mysqli_fetch_array($queryStaff)) { ?>
                        <div class="staff">
                            <div class="staffPhoto"><img src="../img/admin-photo/<?php echo $rowStaff['login']."/".$rowStaff['photo']; ?>" alt=""></div>

                            <div class="staffInformation">
                                <h2><?php echo $rowStaff['name']; ?></h2>
                                <p><?php if($rowStaff['specialization'] == '0'){ echo "Младший брабер"; }elseif($rowStaff['specialization'] == '1'){ echo "Старший барбер"; }elseif($rowStaff['specialization'] == '2'){ echo "Администратор"; }?></p>
                            </div>

                            <div class="staffAction">
                                <a class="staffActionEdit" href="staff.php?edit=<?php echo $rowStaff['id']; ?>">Редактировать</a>
                                <?php if($rowStaff['login'] == $_COOKIE['login']){ }else{ ?> <a class="staffActionDelete" href="staff.php?delete=<?php echo $rowStaff['id']; ?>">Удалить</a> <?php } ?>
                            </div>
                        </div>
                    <?php }
                    
                    ?>
                </div>

                <div id="image"></div>
            </div>
        </section>
    </main>
    
    <script src="js/output.js"></script>
  
</body>
</html>