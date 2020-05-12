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
    $query = "";
    $sql = "";
    if(is_array($value)){
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
    }
    else{
        $sql = "Insert INTO ". $table ." (". $columns .") VALUES (". $value .")";
    }
    $result = mysqli_query($conn, $sql);
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
            else {
                $update_query .= $columns[$i] . " = " . $value[$i]["value"];
            }
            if($i !== count($columns) - 1){
                $update_query .= ", ";
            }         
        }
        $sql = "UPDATE ". $table ." SET ". $update_query ." WHERE id = ". $id .";";
    }
    else{
        $column = $_POST["column"];
        if(is_string($value)){
            $sql = "UPDATE ". $table ." SET ". $column ." = '". $value ."' WHERE id = ". $id .";";
        }
        else{
            $sql = "UPDATE ". $table ." SET ". $column ." = ". $value ." WHERE id = ". $id .";";
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
?>