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
    $sql = "";
    if(is_array($value)){
        $update_query = "";
        for($i = 0; $i < count($column); $i++){
            if($value[$i]["type"] == "string"){
                $update_query .= $column[$i] . " = '" . $value[$i]["value"] . "'";
            }
            else if($value[$i]["type"] == "array"){
                $formatted_addresses = implode(' -> ', $value[$i]["value"]);
                $update_query .= $column[$i] . " = '" . $formatted_addresses . "'";
            }
            else {
                $update_query .= $column[$i] . " = " . $value[$i]["value"] . "";
            }
            if($i !== count($column) - 1){
                $update_query .= ", ";
            }         
        }
        $sql = "Update ". $table ." SET ". $update_query ." WHERE ID = ". $id ."";
    }
    else{
        $sql = "Update ". $table ." SET ". $column ." = ". $value ." WHERE ID = ". $id ."";
    } 
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
// function getData(){
//     $conn = mysqli_connect('localhost', 'root', '', 'luxtur');
//     if (!$conn) {
//         die('Ошибка соединения: ' . mysql_error());
//     }
//     $id = $_POST["id"];
//     $table = getTableName($_POST["table"]);
//     $get_data_obj = mysqli_query($conn, "SELECT * FROM ". $table ." WHERE ID = ". $id ."");
//     if (!$get_data_obj) {
//         die('Неверный запрос: ' . $conn->sqlstate);
//     }
//     mysqli_close($conn);
// }

?>