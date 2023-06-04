<?php 


function paginationOutput($stePagination, $idPage){

    if(isset($_GET['pagination'])){
        $getPagination = $_GET['pagination'];
    }else{
        $getPagination = 1;
    }

    if($stePagination <= 3){
        $paginationMin = 1;
        $paginationMax = $stePagination;
    }else{
        if($getPagination >= 3){
            $paginationMin = $getPagination - 1;
            if($getPagination == $stePagination){
                $paginationMin = $getPagination - 2;
                $paginationMax = $getPagination;
            }else{
                $paginationMax = $getPagination + 1;
            }
        }else{
            $paginationMin = 1;
            $paginationMax = 3;
        }
    }


    $url = $_SERVER['REQUEST_URI'];
    $url = explode('?', $url);
    $url = $url[0];

    if($idPage == null){
        $pageUrl = $url."?";
    }else{
        $pageUrl = $url."?page=".$idPage."&";
    }

    for ($idPagination = $paginationMin; $idPagination <= $paginationMax; $idPagination++){
        echo "<a class='paginationBtn' href='".$pageUrl."pagination=".$idPagination."'>".$idPagination."</a>";
    }
}

?>