<?php
    function convertDataToArray($arr){
        //  converting object of arrays to array
        $result_array = [];
        while($row = mysqli_fetch_array($arr)){
            $result_array[] = $row;
        }
        return $result_array;
    }
    function renderMenu($arr){
        //  render side menu
        for($i = 0; $i < count($arr); $i++){
            echo '<div id="'. $arr[$i]["tag_id"] .'" class="side_menu__item" data-text="'. $arr[$i]["title"] .'">
                    <h3>'. $arr[$i]["title"] .'</h3>
                </div>';
        }
    }
    function renderMenuOnMainTab($arr){
        //  render menu in main tab called "Main" on side menu
        $grid_count = 3;
        $len = count($arr);
		$count_of_rows = $len;
		for($i = 0; $i < $len / $grid_count; $i++){
			echo '<div class="menu_row">';
            $line_count = $count_of_rows >= $grid_count ? $grid_count : $count_of_rows;
            for($j = 0, $index = $i * $grid_count; $j < $line_count; $j++, $index++){
                    echo '<div class="menu_item">';
                        echo '<div id="'. $arr[$index]["tag_id"] .'" class="another" data-text="'. $arr[$index]["title"] .'">';
                            echo '<h2>'. $arr[$index]["title"] .'</h2>';
                        echo '</div>';
                    echo '</div>';
			}
			$count_of_rows-= $grid_count;
			echo '</div>';
	    } 			
    }
    function convertArrayElementsToString($arr, $indexFrom, $indexTo){
        //  convert array "from" elements "to" elements by index to string
        //  it needs for converting end of condition in table
        $resultString = "";
        for($i = $indexFrom; $i < $indexTo; $i++){
            $resultString .= $arr[$i];
            if($i != $indexTo - 1){
                $resultString .= " ";
            }
        }
        return $resultString;
    }
    $con = mysqli_connect('localhost', 'root', '', 'luxtur');
        if (!$con) {
            die('Ошибка соединения: ' . mysql_error());
        }
        $result_phones = mysqli_query($con, "SELECT * FROM contact_phones");                    //  get contact phones from db
        $result_emails = mysqli_query($con, "SELECT * FROM contact_emails");                    //  get contact emails from db
        $result_phone_operators = mysqli_query($con, "SELECT * FROM phone_operators");          //  get phone operators from db
        $result_phone_social_media = mysqli_query($con, "SELECT * FROM phone_social_media");    //  get socials media for phone number from db
        $result_reviews = mysqli_query($con, "SELECT * FROM review");                           //  get all reviews from db
        $sort_review_options = mysqli_query($con, "SHOW COLUMNS FROM review");                  //  get columns names of reviews from db
        $sort_order_options = mysqli_query($con, "SHOW COLUMNS FROM orders");                   //  get columns names of orders from db
        $result_orders = mysqli_query($con, "SELECT * FROM orders");                            //  get orders from db
        $result_calls = mysqli_query($con, "SELECT * FROM calls");                              //  get ordering calls from db
        $result_popular_directions = mysqli_query($con, "SELECT * FROM popular_directions");    //  get popular directions from db 
        $result_our_services = mysqli_query($con, "SELECT * FROM our_service");                 //  get our service from db
        $result_cars = mysqli_query($con, "SELECT * FROM cars");                                //  get autopark (cars info) from db
        $result_price_conditions = mysqli_query($con, "SELECT * FROM condition_names");         //  get conditions name from db
        $result_car_location = mysqli_query($con, "SELECT location FROM car_location");         //  get locations of the car from db
        $result_operators = mysqli_query($con, "SELECT * FROM operators");                      //  get operators for conditions from db
        $result_prices = mysqli_query($con, "SELECT * FROM prices");                            //  get prices info (tariffs) from db
        $result_users = mysqli_query($con, "SELECT * FROM users");                              //  get users from db
        $result_menu = mysqli_query($con, "SELECT * FROM menu");                                //  get menu items from db

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
        else if (!$result_menu) {
            die('Неверный запрос: ' . $con->sqlstate);
        }
        mysqli_close($con);
        
        $eu_car = [];
        $ukr_car = [];
        $all_car = [];
        //  converting cars from database to arrays with certain location
        while($row = mysqli_fetch_array($result_cars)){
            if(strpos($row["location"], 'Україна') !== false){
                $ukr_car[] = $row;
            }
            if (strpos($row["location"], 'Європа') !== false){
                $eu_car[] = $row;
            }
            $all_car[] = $row;
        }
        //  converting result object of the sql request with arrays to array
        $condition_operators = convertDataToArray($result_operators);
        $conditions = convertDataToArray($result_price_conditions);
        $order_columns = convertDataToArray($sort_order_options);
        $all_locations = convertDataToArray($result_car_location);
        $converted_phone_operators = convertDataToArray($result_phone_operators);
        $converted_phone_social_media = convertDataToArray($result_phone_social_media);
        $converted_prices = convertDataToArray($result_prices);
        $converted_users = convertDataToArray($result_users);
        $converted_menu = convertDataToArray($result_menu);
?>