<?php 
    include "functions.php";

    if(isset($_POST["add_order"])){
        insertOrder();
    }   
    else if(isset($_POST["is_call"])){
        getCall();
    }
    else if(isset($_POST["is_review"])){
        getReview();
    }
    else if(isset($_POST["update"])){
        updateQuery();
    }
    else if(isset($_POST["delete"])){
        deleteQuery();
    }
    // else if (isset($_POST["get_data"])) {
    //     getData();
    // }
    else{
        error("Something went wrong!");
    }
?>