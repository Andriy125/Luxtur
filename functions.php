<?php 
function makeConnection(){
    $host = "localhost";    //  Specifies a host name or an IP address
    $login = "root";        //  Specifies the MySQL username
    $password = "";         //  Specifies the MySQL password
    $database = "luxtur";   //  Specifies the default database to be used
    $connection = mysqli_connect($host, $login, $password, $database);
    // Check connection
    if (mysqli_connect_errno()) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
        exit();
    }
    return $connection;
}
function getColumnsString($result){
    //  get formatted string of columns
    $columns = "";
    while($row = mysqli_fetch_array($result)){
        if($row["Field"] !== "id" && $row["Field"] !== "date_time"){
            //  converting columns array to string
            $columns .= $row["Field"] . " ";
        }
    }
    //  trim columns name
    $columns = trim($columns, " ");
    return $columns;
}
function formingQueryOnObjects($value){
    //  forming string query based on input objects
    $query = '';
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
    return $query;         
}
function getTableName($str){
    //  return full table name
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
        case 'p':
            $table_name = "prices";
            break;   
        case 'u':
            $table_name = "users";
            break;          
        default:
            break;
    }
    return $table_name;
}    
function insertOrder(){
    //  making connect
    $conn = makeConnection();
    //  get table name
    $table = getTableName($_POST["table"]);

    $result_columns = mysqli_query($conn, "SHOW COLUMNS FROM ". $table ."");
    //  getting string of columns
    $columns = getColumnsString($result_columns);
    //  append comma between columns name
    $columns = str_replace(" ", ", ", $columns);
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    //  get array of addresses
    $addresses = $_POST["addresses"];
    $goBack = $_POST["goBack"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $passenger_count = $_POST["passenger_count"];
    $car = $_POST["car"];
    $price = $_POST["price"];
    //  convert addresses array to string with separator ' -> '
    $formatted_addresses = implode(' -> ', $addresses);
    $arr = array($name, $phone, $email, $formatted_addresses, $date, $time, $car);
    //  making string for sql request
    $data = implode('\', \'', $arr);

    $sql = "";
    if(isset($_POST["done"])){
        //  if there is "done" that's mean we adding order from admin panel
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
    //  closing connect to database
    mysqli_close($conn);       
}
function insertQuery(){
    //  create connect to database
    $conn = makeConnection();
    //  get table name
    $table = getTableName($_POST["table"]);

    $result_columns = mysqli_query($conn, "SHOW COLUMNS FROM ". $table ."");
    //  getting string of columns
    $columns = getColumnsString($result_columns);
    //  append comma between columns name
    $columns = str_replace(" ", ", ", $columns);
    $value = $_POST["value"];
    $query = "";
    $sql = "";
    if(is_array($value)){
        $query = formingQueryOnObjects($value);    
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
    //  create connection to database
    $conn = makeConnection();
    //  get table name
    $table = getTableName($_POST["table"]);
    $id = $_POST["id"];
    $value = $_POST["value"];
    $sql = "";
    if(is_array($value)){
        $result_columns = mysqli_query($conn, "SHOW COLUMNS FROM ". $table ."");
        $columns = getColumnsString($result_columns);
        $columns = explode(" ", $columns);
        $update_query = "";
        $iterations_count = isset($_POST["iterations"]) ? $_POST["iterations"] : count($columns);
        for($i = 0; $i < $iterations_count; $i++){
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
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die('Неверный запрос: ' . $conn->sqlstate);
    }
    mysqli_close($conn);
}
function deleteQuery(){
    $conn = makeConnection();
    $id = $_POST["id"];
    $table = getTableName($_POST["table"]);
    $result = mysqli_query($conn, "DELETE FROM ". $table ." WHERE ID = ". $id ."");
    if (!$result) {
        die('Неверный запрос: ' . $conn->sqlstate);
    }
    mysqli_close($conn);
}
function authUser(){
    //  if can authenticate user
    $email = $_POST["email"];
    $conn = makeConnection();
    //  get user by email
    $result = mysqli_query($conn, "SELECT id, hash FROM users WHERE user = '". $email ."'");
    if (!$result) {
        die('Неверный запрос: ' . $conn->sqlstate);
    }
    mysqli_close($conn);
    //  get the user
    $user = mysqli_fetch_array($result);
    //  get hash from database
    $user_hash = $user["hash"];
    //  get password from user
    $pass = $_POST["pass"];
    //  generate password from user
    $hashed_pass = generatePassword($pass);
    if(password_verify($hashed_pass, $user_hash)){
        //  if hash by entered password == hash from database
        //  set cookie
        setOwnCookie($user["id"]);
        return true;
    }
    else{
        //  delete cookie
        unsetOwnCookie();
        return false;
    }
    
}
function createUser(){
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    //  hash entered password
    $pass_hash = generateHash(generatePassword($pass));
    //  make connection
    $conn = makeConnection();
    //  insert user to database
    $result = mysqli_query($conn, "INSERT INTO users (user, hash) VALUES ('". $email ."', '". $pass_hash ."')");
    if (!$result) {
        die('Неверный запрос: ' . $conn->sqlstate);
    }
    mysqli_close($conn);
}
function editUser(){
    $id = $_POST["id"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    //  generate hash on entered password
    $pass_hash = generateHash(generatePassword($pass));
    $conn = makeConnection();
    $result = mysqli_query($conn, "UPDATE users SET user = '". $email ."', hash = '". $pass_hash ."' WHERE ID = ". $id ."");
    if (!$result) {
        die('Неверный запрос: ' . $conn->sqlstate);
    }
    mysqli_close($conn);
}
function generatePassword($pass){
    //  generate password
    return md5(md5($pass) . md5("luxturforever"));
}
function generateHash($pass){
    //  generate hash
    return password_hash($pass, PASSWORD_DEFAULT);
}
function generateCookieTime(){
    //  return cookie time
    return time() + 3600 * 24;
}
function setOwnCookie($user_id){
    //  set cookie
    //  set id to cookie 
    setcookie("id", $user["id"], generateCookieTime());
    //  set auth boolean
    setcookie("auth", 1, generateCookieTime());
}
function unsetOwnCookie(){
    //  delete cookies
    setcookie("auth", "", -generateCookieTime());
    setcookie("id", "", -generateCookieTime());
}
?>