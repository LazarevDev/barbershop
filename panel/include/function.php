<?php
function edit($form, $editInput){
    if(isset($_GET['edit'])){
        if(!empty($editInput)){
            if($form == 'input'){
                echo "value='".$editInput."'";
            }elseif($form == 'textarea'){
                echo $editInput;
            }elseif($form == 'submit'){
                echo "Изменить";
            }
        }
    }
}
?>