<?php 
require_once('require/db.php');

?>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<div id="tab2">

<?php
echo $_POST['form_data'];
if(isset($_POST['form_data'])){
    $query = mysqli_query($db, "SELECT * FROM `staff` ORDER BY id DESC");
    while ($row = mysqli_fetch_array($query)) { ?>
        <a class="otkaz_sn" href="<?php echo $row['login']; ?>"><?php echo $row['name'] ?></a><br>
    <?php }

}else{
    echo "no";
}


echo $_POST['ddd'];
?>

</div>

<script>

$(function(){
      $('#content').on('click','.otkaz_sn', function(e) {
          e.preventDefault();
          var d = <?php echo $_POST['form_data']; ?>;
          var f = $(this).attr('href');
        $.ajax({
          url: 'ajax-timedate.php', 
          type: 'POST', 
          data: {form_data : d, ddd: f},
          success: function(data){
            jQuery('#content').html(data);
            
            setTimeout ("$('#content')", 500);
          }
        });
      });
    });
     </script>