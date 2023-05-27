<?php 
require_once('../require/db.php');
require_once('require-panel/cookie.php');

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
        $password = md5($_POST['password']);


        $queryEditLogin = mysqli_query($db, "SELECT * FROM `staff` WHERE `id` = '$editId'");
        $resultEditLogin = mysqli_fetch_array($queryEditLogin);

        
        $photo = $_FILES['photo']['name'];
        $target = "../img/admin-photo/".$resultEditLogin['login']."/".basename($photo);

        echo $photo;

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
                        <tr>
                            <td>Сергей</td>
                            <td>89042988362</td>
                            <td>lazarev.w3b@yandex.ru</td>
                            <td>27.05.2023</td>
                            <td>20.05.2023</td>
                            <td><a href="clients.php?id=">Удалить</a></td>
                        </tr>

                        <tr>
                            <td>Сергей</td>
                            <td>89042988362</td>
                            <td>lazarev.w3b@yandex.ru</td>
                            <td>27.05.2023</td>
                            <td>20.05.2023</td>
                            <td>Удалить</td>
                        </tr>

                        <tr>
                            <td>Сергей</td>
                            <td>89042988362</td>
                            <td>lazarev.w3b@yandex.ru</td>
                            <td>27.05.2023</td>
                            <td>20.05.2023</td>
                            <td>Удалить</td>
                        </tr>

                        <tr>
                            <td>Сергей</td>
                            <td>89042988362</td>
                            <td>lazarev.w3b@yandex.ru</td>
                            <td>27.05.2023</td>
                            <td>20.05.2023</td>
                            <td>Удалить</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </section>
    </main>
    
    <script src="js/output.js"></script>
  
</body>
</html>