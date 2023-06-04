<?php 
session_start();
$service = $_POST['service'];
$_SESSION['service'] = $service;


require_once('../require/db.php');
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


    <h2>Выберите барбера</h2>

    <div class="modalContainer">
        <?php
        $query = mysqli_query($db, "SELECT * FROM `staff` WHERE `specialization` != '2' ORDER BY id DESC");
        while ($row = mysqli_fetch_array($query)) { ?>
            <a class="modalBlock barberBtn" href="<?php echo $row['login']; ?>">
                <div class="modalBlockImg">
                    <img src="../img/admin-photo/<?php echo $row['login']."/".$row['photo']; ?>" alt="">
                </div>

                <div class="modalBlockText"><p><?php echo $row['name'] ?></p></div>
            </a>
        <?php } ?>
    </div>



<script>
$(function(){
    $('#content').on('click','.barberBtn', function(e) {
        e.preventDefault();
        var staff = $(this).attr('href');
    $.ajax({
        url: '../ajax-require/ajax-datetime.php', 
        type: 'POST', 
        data: {staff : staff},
        success: function(data){
        jQuery('#content').html(data);
        
        setTimeout ("$('#content')", 500);
        }
    });
    });
});
</script>