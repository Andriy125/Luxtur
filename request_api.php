<?php 
    function getTableName($str){
        $table_name = "";
        switch ($str) {
            case 'o':
                $table_name = "orders";
                break;
            case 'c_p':
                $table_name = "contact_phones";
                break;
            case 'c_e':
                $table_name = "contact_emails";
                break;
            case 'r':
                $table_name = "review";
                break;
            case 'c':
                $table_name = "calls";
                break;
            
            default:
                # code...
                break;
        }
        return $table_name;
    }    
    function error($msg){
        echo $msg;
    }
    function insertOrder(){
        $conn = mysqli_connect('localhost', 'root', '', 'luxtur');
        if (!$conn) {
            die('Ошибка соединения: ' . mysql_error());
        }
        $table = getTableName($_POST["table"]);
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $addresses = $_POST["addresses"];
        $goBack = $_POST["goBack"] == true ? 1 : 0;
        $date = $_POST["date"];
        $time = $_POST["time"];
        $passenger_count = $_POST["passenger_count"];
        $car = $_POST["car"];
        $price = $_POST["price"];
        $formatted_addresses = implode(' -> ', $addresses);
        $arr = array($name, $phone, $email, $formatted_addresses, $date, $time, $car);
        $data = implode('\', \'', $arr);

        $sql = "";
        if(isset($_POST["done"])){
            $done = $_POST["done"] == true ? 1 : 0;
            $sql = "Insert INTO ". $table ." (name, phone, email, addresses, date, time, car, goBack, passengers, price, done) VALUES ('". $data ."', ". $goBack .", ". $passenger_count .", ". $price .", ". $done .")";
        }
        else{
            $sql = "Insert INTO ". $table ." (name, phone, email, addresses, date, time, car, goBack, passengers, price, done) VALUES ('". $data ."', ". $goBack .", ". $passenger_count .", ". $price .", 0)";
        }

        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die('Неверный запрос: ' . $conn->sqlstate);
        }
        mysqli_close($conn);       
    }
    function getReview(){
        $conn = mysqli_connect('localhost', 'root', '', 'luxtur');
        if (!$conn) {
            die('Ошибка соединения: ' . mysql_error());
        }
        $name = $_POST["name"];
        $review = $_POST["review"];
        $email = $_POST["email"];
        $arr = array($name, $email, $review);
        $data = implode('\', \'', $arr);
        var_dump("Insert INTO review (name, email, review) VALUES ('". $data ."')");

        $result = mysqli_query($conn, "Insert INTO review (name, email, review) VALUES ('". $data ."')");
        if (!$result) {
            die('Неверный запрос: ' . $conn->sqlstate);
        }
        mysqli_close($conn);   
    }
    function getCall(){
        $conn = mysqli_connect('localhost', 'root', '', 'luxtur');
        if (!$conn) {
            die('Ошибка соединения: ' . mysql_error());
        }
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $result = mysqli_query($conn, "Insert INTO calls (name, phone, email) VALUES ('".$name."','". $phone ."' ,'". $email ."')");
        var_dump("Insert INTO calls (name, phone, email) VALUES ('".$name."','". $phone ."' ,'". $email ."')");
        if (!$result) {
            die('Неверный запрос: ' . $conn->sqlstate);
        }
        mysqli_close($conn);
    }
    function updateQuery(){
        $conn = mysqli_connect('localhost', 'root', '', 'luxtur');
        if (!$conn) {
            die('Ошибка соединения: ' . mysql_error());
        }
        $id = $_POST["id"];
        $value = $_POST["value"];
        $column = $_POST["column"];
        $table = getTableName($_POST["table"]);
        $result = mysqli_query($conn, "Update ". $table ." SET ". $column ." = ". $value ." WHERE ID = ". $id ."");
        if (!$result) {
            die('Неверный запрос: ' . $conn->sqlstate);
        }
        mysqli_close($conn);
    }
    function deleteQuery(){
        $conn = mysqli_connect('localhost', 'root', '', 'luxtur');
        if (!$conn) {
            die('Ошибка соединения: ' . mysql_error());
        }
        $id = $_POST["id"];
        $table = getTableName($_POST["table"]);
        $result = mysqli_query($conn, "DELETE FROM ". $table ." WHERE ID = ". $id ."");
        if (!$result) {
            die('Неверный запрос: ' . $conn->sqlstate);
        }
        mysqli_close($conn);
    }

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
    else{
        error("Something went wrong!");
    }
?>