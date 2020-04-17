<?php 
    include 'get_data.php';
?>
<!DOCTYPE html>
<html lang="ua">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LUX TUR</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto&display=swap" rel="stylesheet">
	<script defer src="./js/all.js"></script>
	<link rel="stylesheet" href="css/admin.css">

</head>
<body>
    <header class="admin_header">
        <div class="menu_icon">
            <i class="fas fa-bars"></i>
        </div>
        <h2 class="admin_main_title"></h2>
        <div class="admin_button">
            <h2>
                Logout
            </h2>
        </div>
    </header>

    <div class="side_menu">
        <div class="side_menu_header">
            <h2>Menu</h2>
            <div class="close_icon">
                <h3>
                    <i class="far fa-times-circle"></i>
                </h3> 
            </div>
        </div>
        <div class="side_menu__content">
            <div id="main" class="side_menu__item">
                <h3>Головна</h3>
            </div>
            <div id="edit_price" class="side_menu__item">
                <h3>
                    Редагувати ціни
                </h3> 
            </div>
            <div id="orders" class="side_menu__item">
                <h3>
                    Замовлення
                </h3> 
            </div>
            <div id="edit_review" class="side_menu__item">
                <h3>
                    Редагувати відгуки
                </h3> 
            </div>
            <div id="edit_autopark" class="side_menu__item">
                <h3>
                    Редагувати автопарк
                </h3> 
            </div>
        </div>
    </div>


    <div id="id-main" class="tabcontent">
        <!-- <h3>Головна</h3> -->
    </div>

    <div id="id-edit_price" class="tabcontent">
        <!-- <h3>Редагувати Ціни</h3> -->
    </div>
      
    <div id="id-orders" class="tabcontent">
        <div class="table">
            <table>
                <th class="column">Ім'я</th>
                <th class="column">Телефон</th>
                <th class="column">Email</th>
                <th class="column">Маршрут</th>
                <th class="column">Зворотній шлях</th>
                <th class="column">Дата і час</th>
                <th class="column">Кількість пасажирів</th>
                <th class="column">Машина</th>
                <th class="column">Ціна</th>
                <!-- TODO: filter, CRUD, done or not -->
                <?php 
                    foreach ($result_orders as $order) {
                        echo $order["goBack"] == 1 
                        ? '<tr>
                            <td>'.$order["name"].'</td>
                            <td>'.$order["phone"].'</td>
                            <td>'.$order["email"].'</td>
                            <td>'.$order["addresses"].'</td>
                            <td>Taк</td>
                            <td>'.$order["time"] . "  " . $order["date"] . '</td>
                            <td>'.$order["passengers"].'</td>
                            <td>'.$order["car"].'</td>
                            <td>'.$order["price"].' грн</td>

                        </tr>' 
                        : '<tr>
                            <td>'.$order["name"].'</td>
                            <td>'.$order["phone"].'</td>
                            <td>'.$order["email"].'</td>
                            <td>'.$order["addresses"].'</td>
                            <td>Ні</td>
                            <td>'.$order["time"] . "  " . $order["date"] . '</td>
                            <td>'.$order["passengers"].'</td>
                            <td>'.$order["car"].'</td>
                            <td>'.$order["price"].' грн</td>
                        </tr>' ;
                    }
                ?>

            </table>
        </div>

    </div>
      
    <div id="id-edit_review" class="tabcontent">
        <!-- <h3>Редагувати Відгуки</h3> -->
    </div>

    <div id="id-edit_autopark" class="tabcontent">
        <!-- <h3>Редагувати Автопарк</h3> -->
    </div>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/admin.js"></script>
</body>
</html>