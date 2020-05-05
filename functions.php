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
        case 'p_d':
            $table_name = "popular_directions";
            break;
        case 'ca':
            $table_name = "cars";
            break;
            
        default:
            # code...
            break;
    }
    return $table_name;
}    
function insertOrder(){
    $conn = mysqli_connect('localhost', 'root', '', 'luxtur');
    if (!$conn) {
        die('Ошибка соединения: ' . mysql_error());
    }
    $table = getTableName($_POST["table"]);

    $result_columns = mysqli_query($conn, "SHOW COLUMNS FROM ". $table ."");
    $columns = "";
    while($row = mysqli_fetch_array($result_columns)){
        if($row["Field"] !== "id" && $row["Field"] !== "date_time"){
            $columns .= $row["Field"] . " ";
        }
    }
    $columns = trim($columns, " ");
    $columns = str_replace (" ", ", ", $columns);

    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $addresses = $_POST["addresses"];
    $goBack = $_POST["goBack"];
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
        $done = $_POST["done"];
        $sql = "Insert INTO ". $table ." (name, phone, email, addresses, date, time, car, goBack, passengers, price, done) VALUES ('". $data ."', ". $goBack .", ". $passenger_count .", ". $price .", ". $done .")";
    }
    else{
        $sql = "Insert INTO ". $table ." (name, phone, email, addresses, date, time, car, goBack, passengers, price) VALUES ('". $data ."', ". $goBack .", ". $passenger_count .", ". $price .")";
    }
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die('Неверный запрос: ' . $conn->sqlstate);
    }
    mysqli_close($conn);       
}
function insertQuery(){
    $conn = mysqli_connect('localhost', 'root', '', 'luxtur');
    if (!$conn) {
        die('Ошибка соединения: ' . mysql_error());
    }
    $table = getTableName($_POST["table"]);

    $result_columns = mysqli_query($conn, "SHOW COLUMNS FROM ". $table ."");
    $columns = "";
    while($row = mysqli_fetch_array($result_columns)){
        if($row["Field"] !== "id" && $row["Field"] !== "date_time"){
            $columns .= $row["Field"] . " ";
        }
    }
    $columns = trim($columns, " ");
    $columns = str_replace (" ", ", ", $columns);
    $value = $_POST["value"];
    $sql = "";
    $query = "";
    for($i = 0; $i < count($value); $i++){
        if($value[$i]["type"] == "string"){
            $query .= "'" . $value[$i]["value"] . "'";
        }
        else if($value[$i]["type"] == "number"){
            $query .= $value[$i]["value"];
        }
        if($i !== count($value) - 1){
            $query .= ", ";
        }         
    }
    $sql = "Insert INTO ". $table ." (". $columns .") VALUES (". $query .")";
    echo $sql;
    //$result = mysqli_query($conn, $sql);
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
    $table = getTableName($_POST["table"]);
    
    $id = $_POST["id"];
    $value = $_POST["value"];
    $sql = "";
    if(is_array($value)){
        $result_columns = mysqli_query($conn, "SHOW COLUMNS FROM ". $table ."");
        $columns = "";
        while($row = mysqli_fetch_array($result_columns)){
            if($row["Field"] !== "id" && $row["Field"] !== "date_time"){
                $columns .= $row["Field"] . " ";
            }
        }
        $columns = trim($columns, " ");
        $columns = explode(" ", $columns);
        $update_query = "";
        for($i = 0; $i < count($columns); $i++){
            if($value[$i]["type"] == "string"){
                $update_query .= $columns[$i] . " = '" . $value[$i]["value"] . "'";
            }
            else if($value[$i]["type"] == "array"){
                $formatted_addresses = implode(' -> ', $value[$i]["value"]);
                $update_query .= $columns[$i] . " = '" . $formatted_addresses . "'";
            }
            else {
                $update_query .= $columns[$i] . " = " . $value[$i]["value"] . "";
            }
            if($i !== count($columns) - 1){
                $update_query .= ", ";
            }         
        }
        $sql = "Update ". $table ." SET ". $update_query ." WHERE ID = ". $id ."";
    }
    else{
        $column = $_POST["column"];
        if(is_string($value)){
            $sql = "Update ". $table ." SET ". $column ." = '". $value ."' WHERE ID = ". $id ."";
        }
        else{
            $sql = "Update ". $table ." SET ". $column ." = ". $value ." WHERE ID = ". $id ."";
        }
    } 
    echo $sql;
    $result = mysqli_query($conn, $sql);
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
function insertEmailQuery(){
    $conn = mysqli_connect('localhost', 'root', '', 'luxtur');
    if (!$conn) {
        die('Ошибка соединения: ' . mysql_error());
    }
    $table = getTableName($_POST["table"]);
    $email = $_POST["email"];
    $result = mysqli_query($conn, "Insert INTO ". $table ." ( email ) VALUES ('". $email ."')");
    mysqli_close($conn);
}
function insertPhoneQuery(){
    $conn = mysqli_connect('localhost', 'root', '', 'luxtur');
    if (!$conn) {
        die('Ошибка соединения: ' . mysql_error());
    }
    $table = getTableName($_POST["table"]);
    $phone = $_POST["phone"];
    $operator = $_POST["operator"];
    $social_media = $_POST["social_media"];
    $result = mysqli_query($conn, "Insert INTO ". $table ." ( phone, operator, social_media ) VALUES ('$phone', '$operator', '$social_media')");
    mysqli_close($conn);
}
?>