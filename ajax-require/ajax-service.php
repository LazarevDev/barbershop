



<script>
    $(function(){
        $('#content').on('click','.serviceBtn', function(e) {
            e.preventDefault();
            var service = $(this).attr('href');
            $.ajax({
            url: '../ajax-require/ajax-barbers.php', 
            type: 'POST', 
            data: {service : service},
            success: function(data){
                jQuery('#content').html(data);
                
                setTimeout ("$('#content')", 500);
            }
            });
        });
    });
</script>