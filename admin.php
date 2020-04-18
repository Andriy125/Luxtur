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
                <?php while($order = mysqli_fetch_array($result_orders)): ?>
                        <tr>
                            <td><?php echo $order["name"]?></td>
                            <td><?php echo $order["phone"]?></td>
                            <td><?php echo $order["email"]?></td>
                            <td><?php echo $order["addresses"]?></td>
                            <td><?php echo $order["goBack"] ? "Так" : "Ні"?></td>
                            <td><?php echo $order["time"] . "  " . $order["date"]?></td>
                            <td><?php echo $order["passengers"]?></td>
                            <td><?php echo $order["car"]?></td>
                            <td><?php echo $order["price"]?> грн</td>
                        </tr>
                <?php endwhile;?>

            </table>
        </div>
    </div>
      
    <div id="id-edit_review" class="tabcontent">
        <div class="filter">
            <div>
                <label for="filter_review">Фільтрувати:</label>
                <select id="filter_review" class="filter_review">
                    <option value="all" selected>Всі</option>
                    <option value="showed">Опубліковані</option>
                    <option value="hidden">Приховані</option>
                </select>
            </div>
        </div>

        <div class="sort">
            <div>
            <label for="sort_review">Сортування:</label>
                <select id="sort_review" class="sort_review">
                    <?php foreach ($result_reviews as $key => $value) {
                            foreach ($value as $ky => $val) {
                                if($ky == "id"){
                                    continue;
                                }
                                if($ky !== "show_review"){
                                    echo '<option value="'. $ky .'">'. $ky .'</option>';
                                }
                                else{
                                    break;
                                }
                            }
                        break;
                    } ?>
                </select>
            </div>
        </div>
        
        <div class="table">
            <table class="review_table">
                <tr>
                    <th class="column">Ім'я</th>
                    <th class="column">Email</th>
                    <th class="column">Відгук</th>
                    <th class="column">Відображення</th>
                    <th class="column">Дії</th>
                </tr>
                
                <!-- TODO: filter, CRUD, done or not -->
                <?php while($row = mysqli_fetch_array($result_reviews)):?>
                    <?php echo $row["show_review"] ? '<tr class="all showed">' : '<tr class="all hidden">'; ?>
                        <td><?php echo $row["name"]?></td>
                        <td><?php echo $row["email"]?></td>
                        <td class="wide_cell">"<?php echo $row["review"]?>"</td>
                        <td>
                            <form class="update_review">
                                <input type="hidden" name="id" value="<?php echo $row["id"]?>">
                                <?php echo $row["show_review"] ?  '<input type="checkbox" class="update_review_showing" name="is_showing" checked>'    :  '<input type="checkbox" class="update_review_showing" name="is_showing">' ?>
                            </form>
                        </td>
                        <td>
                            <a class="delete_review" onClick="deleteReview(this.closest('tr'), <?php echo $row["id"]?>);">Видалити</a>
                        </td>  
                    </tr>
                <?php endwhile;?>
               
            </table>
        </div>
    </div>

    <div id="id-edit_autopark" class="tabcontent">
        <!-- <h3>Редагувати Автопарк</h3> -->
    </div>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/sendRequest.js"></script>
    <script src="js/admin.js"></script>
</body>
</html>