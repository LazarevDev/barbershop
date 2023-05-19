<?php 

require_once('require/db.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>


<div class="block">
    <div id="content">
    <?php 
        $query = mysqli_query($db, "SELECT * FROM `services` ORDER BY id DESC");
        while ($row = mysqli_fetch_array($query)) { ?>
            <a class="serviceBtn" href="<?php echo $row['id']; ?>"><?php echo $row['title']; ?> Заказать</a><br>
        <?php } ?>
    </div>
</div>

<?php require_once('ajax-require/ajax-service.php'); ?>

</body>
</html>