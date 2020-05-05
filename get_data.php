<?php
    function convertDataToArray($arr){
        $result_array = [];
        while($row = mysqli_fetch_array($arr)){
            $result_array[] = $row;
        }
        return $result_array;
    }
    $con = mysqli_connect('localhost', 'root', '', 'luxtur');
        if (!$con) {
            die('Ошибка соединения: ' . mysql_error());
        }
        $result_phones = mysqli_query($con, "SELECT * FROM contact_phones");
        $result_emails = mysqli_query($con, "SELECT * FROM contact_emails");
        $result_phone_operators = mysqli_query($con, "SELECT * FROM phone_operators");
        $result_phone_social_media = mysqli_query($con, "SELECT * FROM phone_social_media");
        $result_reviews = mysqli_query($con, "SELECT * FROM review");
        $sort_review_options = mysqli_query($con, "SHOW COLUMNS FROM review");
        $sort_order_options = mysqli_query($con, "SHOW COLUMNS FROM orders");
        $result_orders = mysqli_query($con, "SELECT * FROM orders");
        $result_calls = mysqli_query($con, "SELECT * FROM calls");
        $result_popular_directions = mysqli_query($con, "SELECT * FROM popular_directions");
        $result_our_services = mysqli_query($con, "SELECT * FROM our_service");
        $result_cars = mysqli_query($con, "SELECT * FROM cars");
        $result_car_location = mysqli_query($con, "SELECT location FROM car_location");

        if (!$result_phones) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        else if (!$result_emails) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        else if (!$result_reviews) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        else if (!$result_orders) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        else if (!$sort_review_options) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        else if (!$result_calls) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        else if (!$result_popular_directions) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        else if (!$result_our_services) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        else if (!$result_cars) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        else if (!$result_car_location) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        mysqli_close($con);
        
        $eu_car = [];
        $ukr_car = [];
        $all_car = [];
        $all_locations = [];
        while($row = mysqli_fetch_array($result_cars)){
            if(strpos($row["location"], 'Україна') !== false){
                $ukr_car[] = $row;
            }
            if (strpos($row["location"], 'Європа') !== false){
                $eu_car[] = $row;
            }
            $all_car[] = $row;
        }
        while($row = mysqli_fetch_array($result_car_location)){
            $all_locations[] = $row;
        }

        $converted_phone_operators = convertDataToArray($result_phone_operators);
        $converted_phone_social_media = convertDataToArray($result_phone_social_media);
    function getData(){
        $con = mysqli_connect('localhost', 'root', '', 'luxtur');
        if (!$con) {
            die('Ошибка соединения: ' . mysql_error());
        }
        $result_phones = mysqli_query($con, "SELECT * FROM contact_phones");
        $result_emails = mysqli_query($con, "SELECT * FROM contact_emails");
        $result_phone_operators = mysqli_query($con, "SELECT * FROM phone_operators");
        $result_phone_social_media = mysqli_query($con, "SELECT * FROM phone_social_media");
        $result_reviews = mysqli_query($con, "SELECT * FROM review");
        $sort_review_options = mysqli_query($con, "SHOW COLUMNS FROM review");
        $sort_order_options = mysqli_query($con, "SHOW COLUMNS FROM orders");
        $result_orders = mysqli_query($con, "SELECT * FROM orders");
        $result_calls = mysqli_query($con, "SELECT * FROM calls");
        $result_popular_directions = mysqli_query($con, "SELECT * FROM popular_directions");
        $result_our_services = mysqli_query($con, "SELECT * FROM our_service");
        $result_cars = mysqli_query($con, "SELECT * FROM cars");
        $result_car_location = mysqli_query($con, "SELECT location FROM car_location");

        if (!$result_phones) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        else if (!$result_emails) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        else if (!$result_reviews) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        else if (!$result_orders) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        else if (!$sort_review_options) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        else if (!$result_calls) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        else if (!$result_popular_directions) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        else if (!$result_our_services) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        else if (!$result_cars) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        else if (!$result_car_location) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        mysqli_close($con);
        
        $eu_car = [];
        $ukr_car = [];
        $all_car = [];
        $all_locations = [];
        while($row = mysqli_fetch_array($result_cars)){
            if(strpos($row["location"], 'Україна') !== false){
                $ukr_car[] = $row;
            }
            if (strpos($row["location"], 'Європа') !== false){
                $eu_car[] = $row;
            }
            $all_car[] = $row;
        }
        while($row = mysqli_fetch_array($result_car_location)){
            $all_locations[] = $row;
        }

        $converted_phone_operators = convertDataToArray($result_phone_operators);
        $converted_phone_social_media = convertDataToArray($result_phone_social_media);
    }
    getData();
?>