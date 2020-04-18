<?php 

    function error($msg){
        echo $msg;
    }
    function getOrder(){
        $conn = mysqli_connect('localhost', 'root', '', 'luxtur');
        if (!$conn) {
            die('Ошибка соединения: ' . mysql_error());
        }
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
        $result = mysqli_query($conn, "Insert INTO orders (name, phone, email, addresses, date, time, car, goBack, passengers, price) VALUES ('". $data ."', ". $goBack .", ". $passenger_count .", ". $price .")");
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
    function updateReview(){
        $conn = mysqli_connect('localhost', 'root', '', 'luxtur');
        if (!$conn) {
            die('Ошибка соединения: ' . mysql_error());
        }
        $id = $_POST["id"];
        $is_showing = $_POST["is_showing"];
        $result = mysqli_query($conn, "Update review SET show_review = ". $is_showing ." WHERE ID = ". $id ."");
        if (!$result) {
            die('Неверный запрос: ' . $conn->sqlstate);
        }
        mysqli_close($conn);
    }
    function deleteReview(){
        $conn = mysqli_connect('localhost', 'root', '', 'luxtur');
        if (!$conn) {
            die('Ошибка соединения: ' . mysql_error());
        }
        $id = $_POST["id"];
        $result = mysqli_query($conn, "DELETE FROM review WHERE ID = ". $id ."");
        if (!$result) {
            die('Неверный запрос: ' . $conn->sqlstate);
        }
        mysqli_close($conn);
    }


    if(isset($_POST["is_order"])){
        getOrder();
    }   
    else if(isset($_POST["is_call"])){
        getCall();
    }
    else if(isset($_POST["is_review"])){
        getReview();
    }
    else if(isset($_POST["is_showing"])){
        updateReview();
    }
    else if(isset($_POST["delete_review"])){
        deleteReview();
    }
    else{
        error("Something went wrong!");
    }
?>