<?php 
    include 'get_data.php';
?>
    <?php include "header.php";?>
    <?php include "side_menu.php";?>

<?php
    // Create database connection
    $db = mysqli_connect("localhost", "root", "", "luxtur");

    // Initialize message variable
    $msg = "";
    $target = "img/" . $_FILES["image"]["name"];
    // Get image name
    $image = $target;
    $sql = "";

    if (isset($_POST['p_d'])) {
        // Get text
        $image_text = mysqli_real_escape_string($db, $_POST['text']);
        $sql = "INSERT INTO popular_directions (image, text) VALUES ('$image', '$image_text')";
        // execute query
        mysqli_query($db, $sql);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $msg = "Image uploaded successfully";
        }else{
            $msg = "Failed to upload image";
        }
    }
    else if (isset($_POST['o_s'])) {
        // Get text
        $text = mysqli_real_escape_string($db, $_POST['text']);
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $sql = "INSERT INTO our_service (image, title, text) VALUES ('$image', '$title', '$text')";
        // execute query
        mysqli_query($db, $sql);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $msg = "Image uploaded successfully";
        }else{
            $msg = "Failed to upload image";
        }
    }
    else if (isset($_POST['car'])) {
        // Get text
        $name = mysqli_real_escape_string($db, $_POST['name']);
        $location ="";
        $passengers = $_POST['passengers'];
        $show_car = $_POST['show'] == "show" ? 1 : 0;
        $total = count($_FILES['images']['name']);
        $total_locs = count($_POST['location']);
        $main_image = "img/" .  $_FILES["main_image"]["name"];
        $advantages = $_POST['advantages'];
        $target = "img/" . $_FILES["main_image"]["name"];
        $images = "";

        for($i = 0; $i<$total_locs; $i++){
            $location .= $_POST['location'][$i] . " ";
        }
        // Loop through each file
        for( $i=0 ; $i < $total ; $i++ ) {
            $images .=  "img/" .  $_FILES['images']['name'][$i] . ' ';
            //Get the temp file path
            $tmpFilePath = $_FILES['images']['tmp_name'][$i];

            //Make sure we have a file path
            if ($tmpFilePath != ""){
                //Setup our new file path
                $newFilePath = "./img/" . $_FILES['images']['name'][$i];

                //Upload the file into the temp dir
                if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                    $msg = "Image uploaded successfully";
                }
                else{
                    $msg = "Failed to upload image";
                    return;
                }
            }
        }
        $sql = "INSERT INTO car (name, location, passengers, main_image, images, advantages, show_car) VALUES ('$name', '$location', $passengers, '$main_image', '$images', '$advantages', $show_car)";
        // execute query
        mysqli_query($db, $sql);
        if (move_uploaded_file($_FILES['main_image']['tmp_name'], $target)) {
            $msg = "Image uploaded successfully";
        }else{
            $msg = "Failed to upload image";
        }
    }

    mysqli_close($db);
?>

    <div id="id-main" class="tabcontent">
        <!-- <h3>Головна</h3> -->
    </div>

    <div id="id-edit_price" class="tabcontent">
        <!-- <h3>Редагувати Ціни</h3> -->
    </div>

    <div id="id-edit_calls" class="tabcontent">
        <div class="content_container">
            <div class="table_container">
                <table class="email_table">
                    <tr>
                       <th class="column">Ім'я</th>
                       <th class="column">Телефон</th>
                       <th class="column">Email</th>
                       <th class="column">Додано</th>
                       <th class="column">Дії</th>
                    </tr>
                    <?php while($row = mysqli_fetch_array($result_calls)):?>
                    <tr>
                        <td><?php echo $row["name"]?></td>
                        <td><?php echo $row["phone"]?></td>
                        <td><?php echo $row["email"]?></td>
                        <td><?php echo $row["date_time"]?></td>
                        <td>
                            <form class="delete_form_c">
                                <input type="hidden" name="id" value="<?php echo $row["id"]?>">
                            </form>
                            <a class="delete_button del_call">Видалити</a>
                        </td>  
                    </tr>
                    <?php endwhile;?>
                </table>
            </div>
        </div>
    </div>

    <div id="id-add_popular_directions" class="tabcontent">
        <div class="form_container">
            <form class="add_popular_directions_form" method="POST" action="admin.php" enctype="multipart/form-data">
                <input type="hidden" name="p_d">                
                <input placeholder="Введіть назву місця..." type="text" name="text" required>                
                <input type="file" name="image" accept=".png, .jpg, .jpeg">                
                <div class="submit_block">
                    <button type="submit" class="add_button">Додати</button>
                </div>
            </form>
        </div>
    </div>

    <div id="id-edit_popular_directions" class="tabcontent">
        <div class="content_container">
            <div class="add_block">
                <div id="add_popular_directions" class="another">
                    <h3>
                        <a class="add_link">Додати новий блок в "Популярні напрямки"</a> 
                    </h3> 
                </div>
            </div>  
            <table>
                <tr>
                    <th class="column">Зображення</th>
                    <th class="column">Місце</th>
                    <th class="column">Додано</th>
                    <th class="column">Дії</th>
                </tr>
                <?php while($row = mysqli_fetch_array($result_popular_directions)):?>
                    <tr>
                        <td><img class="o_s_image" src="/<?php echo $row["image"]?>" alt="<?php echo $row["text"]?>"></td>
                        <td><?php echo $row["text"]?></td>
                        <td><?php echo $row["date_time"]?></td>
                        <td>
                            <form class="delete_form_c">
                                <input type="hidden" name="id" value="<?php echo $row["id"]?>">
                            </form>
                            <a class="delete_button del_call">Видалити</a>
                        </td>  
                    </tr>
                <?php endwhile;?>
            </table>     
        </div>
    </div>

    <div id="id-add_our_service" class="tabcontent">
        <div class="form_container">
            <form class="add_popular_directions_form" method="POST" action="admin.php" enctype="multipart/form-data">
                <input type="hidden" name="o_s">                
                <input placeholder="Введіть заголовок..." type="text" name="title" required>                
                <textarea placeholder="Введіть текст..." class="order_addresses" name="text" required></textarea>               
                <input type="file" name="image" accept=".png, .jpg, .jpeg">                
                <div class="submit_block">
                    <button type="submit" class="add_button">Додати</button>
                </div>
            </form>
        </div>
    </div>

    <div id="id-edit_our_service" class="tabcontent">

        <div class="content_container">
            <div class="add_block">
                <div id="add_our_service" class="another">
                    <h3>
                        <a class="add_link">Додати новий блок в "Наші послуги"</a> 
                    </h3> 
                </div>
            </div>
            <table>
            <tr>
                <th class="column">Зображення</th>
                <th class="column">Заголовок</th>
                <th class="column">Опис</th>
                <th class="column">Додано</th>
                <th class="column">Дії</th>
            </tr>
            <?php while($row = mysqli_fetch_array($result_our_services)):?>
                <tr>
                    <td><img class="o_s_image" src="/<?php echo $row["image"]?>" alt="<?php echo $row["title"]?>"></td>
                    <td><?php echo $row["title"]?></td>
                    <td class="wide_cell"><?php echo $row["text"]?></td>
                    <td><?php echo $row["date_time"]?></td>
                    <td class="actions_col">
                        <form class="delete_form_o_s">
                            <input type="hidden" name="id" value="<?php echo $row["id"]?>">
                        </form>
                        <a class="delete_button del_our_service">Видалити</a>
                    </td>  
                </tr>
            <?php endwhile;?>
            </table>  
        </div>        
    </div>

    <div id="id-edit_order" class="tabcontent">
        <div class="form_container">
            <form class="edit_order_form">
                <input type="hidden" name="id">
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
                    <button id="orders" type="submit" class="add_button another">Відредагувати</button>
                </div>
            </form>
        </div>
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
                    <select id="direction" name="goBack">
                        <option value="one" selected>Ні</option>
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
                    <button type="submit" class="add_button">Додати</button>
                </div>
            </form>
        </div>
    </div>
      
    <div id="id-orders" class="tabcontent">
        <div class="content_container">
            <div class="add_block">
                <div id="add_order" class="another">
                    <h3>
                        <a class="add_link">Додати замовлення</a> 
                    </h3> 
                </div>
            </div>
            <div class="filter">
                <div>
                    <label for="filter_order">Фільтрувати:</label>
                    <select id="filter_order" class="filter_order">
                        <option value="all" selected>Всі</option>
                        <option value="done">Виконані</option>
                        <option value="not_completed">Не виконані</option>
                    </select>
                </div>
            </div>

            <div class="sort">
                <div>
                <label for="sort_order">Сортування:</label>
                    <select id="sort_order" class="sort_order">
                        <?php 
                            while($row = mysqli_fetch_array($sort_order_options)){
                                if($row['Field'] !== "done" && $row['Field'] !== "id")
                                echo '<option value="'. $row['Field'] .'">'. $row['Field'] .'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <table class="order_table">
                <th class="column">Ім'я</th>
                <th class="column">Телефон</th>
                <th class="column">Email</th>
                <th class="column">Маршрут</th>
                <th class="column">Зворотній шлях</th>
                <th class="column">Дата і час</th>
                <th class="column">Кількість пасажирів</th>
                <th class="column">Автобус</th>
                <th class="column">Ціна</th>
                <th class="column">Додано</th>
                <th class="column">Виконано</th>
                <th class="column">Дії</th>
                <!-- TODO: filter, CRUD, done or not -->
                <?php while($order = mysqli_fetch_array($result_orders)): 
                        echo $order["done"] ? '<tr class="all done">' : '<tr class="all not_completed">';
                ?>
                            <td><?php echo $order["name"]?></td>
                            <td><?php echo $order["phone"]?></td>
                            <td><?php echo $order["email"]?></td>
                            <td><?php echo $order["addresses"]?></td>
                            <td><?php echo $order["goBack"] ? "Так" : "Ні"?></td>
                            <td><?php echo $order["time"] . "  " . $order["date"]?></td>
                            <td><?php echo $order["passengers"]?></td>
                            <td><?php echo $order["car"]?></td>
                            <td><?php echo $order["price"]?> грн</td>
                            <td><?php echo $order["date_time"]?></td>
                            <td>
                                <form class="update_order">
                                    <input type="hidden" name="id" value="<?php echo $order["id"]?>">
                                    <?php echo $order["done"] ?  '<input type="checkbox" class="update_order_done" name="order_done" checked>'    :  '<input type="checkbox" class="update_order_done" name="order_done">' ?>
                                </form>
                            </td>
                            <td>
                                <a id="edit_order" class="edit_button edit_order another">Редагувати</a>
                                <form class="delete_form_o">
                                    <input type="hidden" name="id" value="<?php echo $order["id"]?>">
                                </form>
                                <a class="delete_button del_order">Видалити</a>
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
                            <form class="delete_form_r">
                                <input type="hidden" name="id" value="<?php echo $row["id"]?>">
                            </form>
                            <a class="delete_button del_review">Видалити</a>
                        </td>  
                    </tr>
                <?php endwhile;?>
               
            </table>
        </div>
    </div>

    <div id="id-add_car" class="tabcontent">
        <div class="form_container">
            <form class="add_car_form" method="POST" action="admin.php" enctype="multipart/form-data">
                <input type="hidden" name="car">                
                <input placeholder="Введіть назву автобус..." type="text" name="name" >                
                <input placeholder="Введіть кількість пасажирів..." type="number" min="1" name="passengers" >                
                <input type="file" name="main_image" accept=".png, .jpg, .jpeg" >                
                <input type="file" name="images[]" accept=".png, .jpg, .jpeg" multiple >  
                <textarea class="order_addresses" name="advantages" placeholder="Введіть переваги..." cols="30" rows="10"></textarea>  
                <select name="location[]" multiple>
                    <?php while($row = mysqli_fetch_array($result_car_location)): ?>
                        <option value="<?php echo $row["location"]; ?>"><?php echo $row["location"]; ?></option>
                    <?php endwhile;?>
                </select>            
                <div class="done_block">
                    <label for="is_show">Відображати</label>
                    <input id="is_show" type="checkbox" name="show" value="show">
                 </div>
                <div class="submit_block">
                    <button type="submit" class="add_button">Додати</button>
                </div>
            </form>
        </div>
    </div>

    <div id="id-edit_autopark" class="tabcontent">
        <div class="content_container">
            <div class="add_block">
                <div id="add_car" class="another">
                    <h3>
                        <a class="add_link">Додати Автобус</a> 
                    </h3> 
                </div>
            </div>
            <div class="table_container">
                <table class="autopark_table">
                    <tr>
                       <th class="column">Назва</th>
                       <th class="column">Локація</th>
                       <th class="column">К-сть пасажирів</th>
                       <th class="column">Головне зображення</th>
                       <th class="column">Зображення</th>
                       <th class="column">Переваги</th>
                       <th class="column">Додано</th>
                       <th class="column">Відображати</th>
                       <th class="column">Дії</th>
                    </tr>
                    <?php while($row = mysqli_fetch_array($result_car)):?>
                    <tr>
                        <td><?php echo $row["name"]?></td>
                        <td>
                            <ul>
                            <?php 
                                $locs = explode(" ", $row["location"]);
                                for($i = 0; $i < count($locs) - 1; $i++):   
                            ?>
                                <li><?php echo $locs[$i]; ?></li>
                            <?php endfor;?>  
                            </ul>
                        </td>
                        <td><?php echo $row["passengers"]?></td>
                        <td><img style="width:85%; height:85%" src="<?php echo $row["main_image"]?>" alt ="<?php echo $row["name"]?>"></td>
                        <td>
                            <?php 
                                $imgs = explode(" ", $row["images"]);
                                for($i = 0; $i < count($imgs) - 1; $i++):   
                            ?>
                                <img style="width: 150px; height:150px; margin-right:5px" src="<?php echo $imgs[$i]; ?>">
                            <?php endfor;?>                                                      
                        </td>
                        <td style="text-align:left;"><?php echo nl2br($row["advantages"])?></td>
                        <td><?php echo $row["date_time"]?></td>
                        <td>
                            <form class="update_car">
                                <input type="hidden" name="id" value="<?php echo $row["id"]?>">
                                <?php 
                                    $checkbox = '<input type="checkbox" class="update_car_showing" name="is_showing" ';
                                    $checkbox .= $row["show_car"] == 1 ? 'checked>' : '>'; 
                                    echo $checkbox;
                                ?>
                            </form>
                        </td>
                        <td>
                            <a id="edit_order" class="edit_button edit_car another">Редагувати</a>
                            <form class="delete_form_a">
                                <input type="hidden" name="id" value="<?php echo $row["id"]?>">
                            </form>
                            <a class="delete_button del_car">Видалити</a>
                        </td>  
                    </tr>
                    <?php endwhile;?>
                </table>
            </div>
        </div>
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
                            <form class="delete_form_e">
                                <input type="hidden" name="id" value="<?php echo $row["id"]?>">
                            </form>
                            <a class="delete_button del_email">Видалити</a>
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
                            <form class="delete_form_p">
                                <input type="hidden" name="id" value="<?php echo $row["id"]?>">
                            </form>
                            <a class="delete_button del_phone">Видалити</a>
                        </td>  
                    </tr>
                <?php endwhile;?>
                </table>
            </div>

        </div>
    </div>

<?php include "footer.php";?>