<?php 
include_once('include/header.php'); 
require_once('require/db.php');

?>

<link rel="stylesheet" href="css/staff-component.css">

<section class="sectionPage">
    <div class="container">
        <div class="titleSection">
            <h2>Наши сотрудники</h2>
        </div>

        <div class="staffContainer">
            <?php 
            $queryStaff = mysqli_query($db, "SELECT * FROM `staff` WHERE `specialization` != '2' ORDER BY id DESC");
            while ($rowStaff = mysqli_fetch_array($queryStaff)) { ?>
                <a href="employee.php?id=<?php echo $rowStaff['id']; ?>" class="staffBlock">
                    <div class="staffImg"><img src="img/admin-photo/<?php echo $rowStaff['login']."/".$rowStaff['photo']; ?>" alt=""></div>
                    <div class="staffName">
                        <h2><?php echo $rowStaff['name']; ?></h2>
                        <p><?php if($rowStaff['specialization'] == '0'){
                             echo "Младший барбер";
                        }elseif($rowStaff['specialization'] == '1'){
                            echo "Старший барбер";
                        } ?></p>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>
</section>

<?php include_once('include/footer.php'); ?>