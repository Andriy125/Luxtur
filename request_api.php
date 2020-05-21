<?php 
    include "functions.php";

    if(isset($_POST["add_order"])){
        insertOrder();
    }   
    else if(isset($_POST["update"])){
        updateQuery();
    }
    else if(isset($_POST["delete"])){
        deleteQuery();
    }
    else if(isset($_POST["insert"])){
        insertQuery();
    }
    else if(isset($_POST["e_user"])){
        editUser();
    }
    else if(isset($_POST["c_user"])){
        createUser();
    }
    else{
        error("Something went wrong!");
    }
?>