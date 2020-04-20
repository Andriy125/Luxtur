<?php 
    include 'get_data.php';
?>
    <?php include "header.php";?>
    <?php include "side_menu.php";?>


    <div id="id-main" class="tabcontent">
        <!-- <h3>Головна</h3> -->
    </div>

    <div id="id-edit_price" class="tabcontent">
        <!-- <h3>Редагувати Ціни</h3> -->
    </div>

    <div id="id-add_order" class="tabcontent">
        <div class="form_container">
            <form class="add_order_form">
                <input placeholder="Введіть ім'я..." type="text" name="name" required>
                <input type="tel" class="phone" name="phone" required>
                <input placeholder="Введіть email..." type="email" name="email" required>
                <div>
                    <textarea required class="order_addresses" placeholder="Введіть адреси..." name="addresses" cols="30" rows="10"></textarea>
                </div>
                <div class="direction_block">
                    <label for="direction">Зворотній шлях</label>
                    <select id="direction" name="goBack" required>
                        <option value="one">Ні</option>
                        <option value="duo">Так</option>
                    </select>
                </div>
                <div class="date-time_block">
                    <div>
                        <p>Дата і час</p>
                    </div>
                    <div class="date-time_block__inputs">
                        <input class="input_date" type="date" name="date" required>
                        <input class="input_time" type="time" name="time" required>
                    </div>
                </div>

                <input placeholder="Введіть кількість пасажирів..." type="number" min="1" name="passengers" required>
                <input placeholder="Введіть назву автобуса..." type="text" name="car" required>
                <input placeholder="Введіть ціну..." type="number" min="0" name="price" required>
                <div class="done_block">
                    <label for="is_done">Виконано</label>
                    <input id="is_done" type="checkbox" name="done">
                 </div>
                <div class="submit_block">
                    <button type="submit" class="add_order_button">Додати</button>
                </div>
            </form>
        </div>
    </div>
      
    <div id="id-orders" class="tabcontent">
        <div class="content_container">
            <div class="add_order_block">
                <div id="add_order" class="another">
                    <h3>
                        <a class="add_order_link">Додати замовлення</a> 
                    </h3> 
                </div>
            </div>
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
                <th class="column">Виконано</th>
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
                            <td>
                                <form class="update_order">
                                    <input type="hidden" name="id" value="<?php echo $order["id"]?>">
                                    <?php echo $order["done"] ?  '<input type="checkbox" class="update_order_done" name="order_done" checked>'    :  '<input type="checkbox" class="update_order_done" name="order_done">' ?>
                                </form>
                            </td>
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
                    <?php 
                        while($row = mysqli_fetch_array($sort_review_options)){
                            if($row['Field'] !== "show_review" && $row['Field'] !== "id")
                            echo '<option value="'. $row['Field'] .'">'. $row['Field'] .'</option>';
                        }
                    ?>
                </select>
            </div>
        </div>
        
        <div class="content_container">
            <table class="review_table">
                <tr>
                    <th class="column">Ім'я</th>
                    <th class="column">Email</th>
                    <th class="column">Відгук</th>
                    <th class="column">Додано</th>
                    <th class="column">Відображення</th>
                    <th class="column">Дії</th>
                </tr>
                
                <!-- TODO: filter, CRUD, done or not -->
                <?php while($row = mysqli_fetch_array($result_reviews)):?>
                    <?php echo $row["show_review"] ? '<tr class="all showed">' : '<tr class="all hidden">'; ?>
                        <td><?php echo $row["name"]?></td>
                        <td><?php echo $row["email"]?></td>
                        <td class="wide_cell">"<?php echo $row["review"]?>"</td>
                        <td><?php echo $row["date_time"]?></td>
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

    <div id="id-edit_contacts" class="tabcontent">
        <div class="content_container">
            <div class="table_container">
                <table class="email_table">
                    <tr>
                       <th class="column">Email</th>
                       <th class="column">Додано</th>
                       <th class="column">Дії</th>
                    </tr>
                    <?php while($row = mysqli_fetch_array($result_emails)):?>
                    <tr>
                        <td><?php echo $row["email"]?></td>
                        <td><?php echo $row["date_time"]?></td>
                        <td>
                            <a class="delete_review" onClick="deleteReview(this.closest('tr'), <?php echo $row["id"]?>);">Видалити</a>
                        </td>  
                    </tr>
                    <?php endwhile;?>
                </table>
            </div>

            <div class="table_container">
                <table class="phone_table">
                    <tr>
                       <th class="column">Номер телефону</th>
                       <th class="column">Оператор</th>
                       <th class="column">Соціальні мережі</th>
                       <th class="column">Додано</th>
                       <th class="column">Дії</th>
                    </tr>
                    <?php while($row = mysqli_fetch_array($result_phones)):?>
                    <?php 
                        $classList = "all ";
                    if(strtolower($row["social_media"]) == "viber"){
                        $classList .= "viber ";
                    }  
                    if(strtolower($row["operator"]) == "kyivstar"){
                        $classList .= "kyivstar ";
                    }
                    else if(strtolower($row["operator"]) == "vodaphone"){
                        $classList .= "vodaphone ";
                    }
                        echo '<tr class="'. $classList .'">'; 
                    ?>
                        <td><?php echo $row["phone"]?></td>
                        <td><?php echo $row["operator"]?></td>
                        <td><?php echo strtoupper($row["social_media"])?></td>
                        <td><?php echo $row["date_time"]?></td>
                        <td>
                            <a class="delete_review" onClick="deleteReview(this.closest('tr'), <?php echo $row["id"]?>);">Видалити</a>
                        </td>  
                    </tr>
                <?php endwhile;?>
                </table>
            </div>

        </div>
    </div>

<?php include "footer.php";?>