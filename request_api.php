<?php 
    include "functions.php";            //  include functions from function.php

    if(isset($_POST["add_order"])){     //  if add order request from site (there isn't "done" key)
        insertOrder();
    }   
    else if(isset($_POST["update"])){   //  if update request
        updateQuery();
    }
    else if(isset($_POST["delete"])){   //  if delete request
        deleteQuery();
    }
    else if(isset($_POST["insert"])){   //  if insert request
        insertQuery();
    }
    else if(isset($_POST["e_user"])){   //  if edit user request
        editUser();
    }
    else if(isset($_POST["c_user"])){   //  if create user request
        createUser();
    }
    else{
        error("Something went wrong!");
    }
?>