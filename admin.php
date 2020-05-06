<?php 
    include 'get_data.php';
    include "index_request_api.php";
?>
    <?php include "header.php";?>
    <?php include "side_menu.php";?>

    <div id="id-main" class="tabcontent">
        <!-- <h3>Головна</h3> -->
    </div>

    <div id="id-edit_price" class="tabcontent">
        <!-- <h3>Редагувати Ціни</h3> -->
    </div>

    <div id="id-edit_call" class="tabcontent">
        <div class="form_container">
            <form class="edit_call_form">            
                <input type="hidden" name="id">
                <input type="text" placeholder="Введіть ім'я..." name="name" required>
				<input type="text" name="phone" class="phone" required>
				<input type="email" name="email" placeholder="Введіть E-mail..." required>                       
                <div class="submit_block">
                    <button type="submit" class="add_button">Відредагувати</button>
                    <div id="calls" class="another" data-text="Замовлення дзвінків">
                        <a class="add_button">Назад</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="id-add_call" class="tabcontent">
        <div class="form_container">
        <form class="add_call_form">            
                <input type="text" placeholder="Введіть ім'я..." name="name" required>
				<input type="text" name="phone" class="phone" required>
				<input type="email" name="email" placeholder="Введіть E-mail..." required>                       
                <div class="submit_block">
                    <button type="submit" class="add_button">Додати</button>
                    <div id="calls" class="another" data-text="Замовлення дзвінків">
                        <a class="add_button">Назад</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="id-calls" class="tabcontent">
        <div class="content_container">
            <div class="table_container">
                <div class="add_block">
                    <div id="add_call" data-text="Додати Замовлення дзвінка" class="another">
                        <h3>
                            <a class="add_link">Додати Замовлення дзвінка</a> 
                        </h3> 
                    </div>
                </div>  
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
                            <div id="edit_call" data-text="Редагувати Замовлення дзвінків" class="another">
                                <a class="edit_button edit_call">Редагувати</a>
                            </div> 
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

    <div id="id-edit_popular_directions" class="tabcontent">
        <div class="form_container">
            <form class="edit_popular_directions_form" method="POST" action="admin.php" enctype="multipart/form-data">
                <input type="hidden" name="e_p_d">                
                <input type="hidden" name="id">                
                <input placeholder="Введіть назву місця..." type="text" name="text" required>
                <div class="center_image">
                    <img class="edit_p_d_img" src="" alt="">
                    <input type="file" name="image" accept=".png, .jpg, .jpeg">                
                </div>                
                <div class="submit_block">
                    <button type="submit" class="add_button">Відредагувати</button>
                    <div id="popular_directions" class="another" data-text="Популярні напрямки">
                        <a class="add_button">Назад</a>
                    </div>
                </div>
            </form>
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
                    <div id="popular_directions" class="another" data-text="Популярні напрямки">
                        <a class="add_button ">Назад</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="id-popular_directions" class="tabcontent">
        <div class="content_container">
            <div class="add_block">
                <div id="add_popular_directions" data-text='Додати новий блок в "Популярні напрямки"' class="another">
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
                            <div id="edit_popular_directions" data-text='Редагувати блок "Популярні напрямки"' class="another">
                                <a class="edit_button edit_p_d">Редагувати</a>
                            </div>
                            <form class="delete_form_p_d">
                                <input type="hidden" name="id" value="<?php echo $row["id"]?>">
                            </form>
                            <a class="delete_button del_p_d">Видалити</a>
                        </td>  
                    </tr>
                <?php endwhile;?>
            </table>     
        </div>
    </div>

    <div id="id-edit_our_service" class="tabcontent">
        <div class="form_container">
            <form class="edit_our_service_form" method="POST" action="admin.php" enctype="multipart/form-data">
                <input type="hidden" name="e_o_s">                
                <input type="hidden" name="id">                
                <input placeholder="Введіть заголовок..." type="text" name="title" required>  
                <div class="center_image">
                    <img class="e_o_s_img" src="" alt="">
                    <input type="file" name="image" accept=".png, .jpg, .jpeg">                    
                </div>                
                <textarea placeholder="Введіть текст..." class="order_addresses" name="text" required></textarea>            
                <div class="submit_block">
                    <button type="submit" class="add_button">Відредагувати</button>
                    <div id="our_service" class="another"  data-text="Наші послуги">
                        <a class="add_button">Назад</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="id-add_our_service" class="tabcontent">
        <div class="form_container">
            <form class="add_popular_directions_form" method="POST" action="admin.php" enctype="multipart/form-data">
                <input type="hidden" name="o_s">                
                <input placeholder="Введіть заголовок..." type="text" name="title" required>                
                <textarea placeholder="Введіть текст..." class="order_addresses" name="text" required></textarea>               
                <input type="file" name="image" accept=".png, .jpg, .jpeg" required>                
                <div class="submit_block">
                    <button type="submit" class="add_button">Додати</button>
                    <div id="our_service" class="another" data-text="Наші послуги">
                        <a class="add_button">Назад</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div id="id-our_service" class="tabcontent">
        <div class="content_container">
            <div class="add_block">
                <div id="add_our_service" data-text="Додати новий блок в Наші послуги" class="another">
                    <h3>
                        <a class="add_link">Додати новий блок в Наші послуги</a> 
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
                        <div id="edit_our_service" data-text="Редагувати Наші послуги" class="another">
                            <a class="edit_button edit_o_s">Редагувати</a>
                        </div>
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
                    <a id="orders" class="add_button another" data-text="Замовлення">Назад</a>
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
                    <a id="orders" class="add_button another" data-text="Замовлення">Назад</a>
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
                                <div id="edit_order" data-text="Редагувати Замовлення" class="another">
                                    <a class="edit_button edit_order ">Редагувати</a>
                                </div>
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

    <div id="id-add_review" class="tabcontent">
        <div class="form_container">
            <form class="add_review_form" >                           
                <input placeholder="Введіть ім'я..." type="text" name="name" required>                
                <input placeholder="Введіть email..." type="email" name="email" required>           
                <textarea class="order_addresses" name="review" placeholder="Введіть відгук..." cols="30" rows="10" required></textarea>
                <div class="done_block">
                    <label for="is_show">Відображати</label>
                    <input id="is_show" type="checkbox" name="show_review">
                 </div>
                <div class="submit_block">
                    <button type="submit" class="add_button">Додати</button>
                    <a id="reviews" class="add_button another" data-text="Редагувати відгуки">Назад</a>
                </div>
            </form>
        </div>
    </div>

    <div id="id-edit_review" class="tabcontent">
        <div class="form_container">
            <form class="edit_review_form" >
                <input type="hidden" name="id">                            
                <input placeholder="Введіть ім'я..." type="text" name="name" required>                
                <input placeholder="Введіть email..." type="email" name="email" required>           
                <textarea class="order_addresses" name="review" placeholder="Введіть відгук..." cols="30" rows="10" required></textarea>  

                <div class="done_block">
                    <label for="is_show">Відображати</label>
                    <input id="is_show" type="checkbox" name="show_review">
                 </div>

                <div class="submit_block">
                    <button type="submit" class="add_button">Відредагувати</button>
                    <a id="reviews" class="add_button another" data-text="Редагувати відгуки">Назад</a>
                </div>
            </form>
        </div>
    </div>

    <div id="id-reviews" class="tabcontent">
        <div class="content_container">
            <div class="add_block">
                <div id="add_review" data-text="Додати Відгук" class="another">
                    <h3>
                        <a class="add_link">Додати Відгук</a> 
                    </h3> 
                </div>
            </div>
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
                        <?php while($row = mysqli_fetch_array($sort_review_options)){
                                if($row['Field'] !== "show_review" && $row['Field'] !== "id")
                                echo '<option value="'. $row['Field'] .'">'. $row['Field'] .'</option>';
                            }?>
                    </select>
                </div>
            </div>
            <table class="review_table">
                <tr>
                    <th class="column">Ім'я</th>
                    <th class="column">Email</th>
                    <th class="column">Відгук</th>
                    <th class="column">Додано</th>
                    <th class="column">Відображення</th>
                    <th class="column">Дії</th>
                </tr>
                
                <?php while($row = mysqli_fetch_array($result_reviews)):?>
                    <?php echo $row["show_review"] ? '<tr class="all showed">' : '<tr class="all hidden">'; ?>
                        <td><?php echo $row["name"]?></td>
                        <td><?php echo $row["email"]?></td>
                        <td class="wide_cell">"<?php echo $row["review"]?>"</td>
                        <td><?php echo $row["date_time"]?></td>
                        <td>
                            <form class="update_review">
                                <input type="hidden" name="id" value="<?php echo $row["id"]?>">
                                <?php $checkbox = '<input type="checkbox" class="update_review_showing" name="is_showing" ';
                                   $checkbox .= $row["show_review"] ?  'checked>': '>';
                                    echo $checkbox;
                                ?>
                            </form>
                        </td>
                        <td>
                            <div id="edit_review" data-text="Редагувати відгуки" class="another">
                                <a class="edit_button edit_review" >Редагувати</a>
                            </div>
                            
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

    <div id="id-edit_car" class="tabcontent">
        <div class="form_container">
            <form class="edit_car_form" method="POST" action="admin.php" enctype="multipart/form-data">
                <input type="hidden" name="id">                
                <input type="hidden" name="edit_car">                
                <input placeholder="Введіть назву автобус..." type="text" name="name" >                
                <input placeholder="Введіть кількість пасажирів..." type="number" min="1" name="passengers">   
                <div class="center_image">
                    <img class="edit_car_main_image" src="" alt="">
                    <input type="file" name="main_image" accept=".png, .jpg, .jpeg" >  
                </div>             
                <div class="center_image edit_car_imgs">
                </div>
                <input type="file" name="images[]" accept=".png, .jpg, .jpeg" multiple>  
                <textarea class="order_addresses" name="advantages" placeholder="Введіть переваги..." cols="30" rows="10"></textarea> 

                <select id="locs" name="location[]" multiple>
                    <?php for($i = 0; $i < count($all_locations); $i++):?>
                        <option value="<?php echo $all_locations[$i]["location"]; ?>"><?php echo $all_locations[$i]["location"]; ?></option>
                    <?php endfor;?>
                </select>   

                <div class="done_block">
                    <label for="is_show">Відображати</label>
                    <input id="is_show" type="checkbox" name="show" value="show">
                 </div>

                <div class="submit_block">
                    <button type="submit" class="add_button">Відредагувати</button>
                    <a id="edit_autopark" class="add_button another" data-text="Редагувати автопарк">Назад</a>
                </div>
            </form>
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
                    <?php for($i = 0; $i < count($all_locations); $i++): ?>
                        <option value="<?php echo $all_locations[$i]["location"]; ?>"><?php echo $all_locations[$i]["location"]; ?></option>
                    <?php endfor;?>
                </select>            
                <div class="done_block">
                    <label for="is_show">Відображати</label>
                    <input id="is_show" type="checkbox" name="show" value="show">
                 </div>
                <div class="submit_block">
                    <button type="submit" class="add_button">Додати</button>
                    <a id="edit_autopark" class="add_button another" data-text="Редагувати автопарк">Назад</a>
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
                    <?php for($i = 0; $i < count($all_car); $i++):?>
                    <tr>
                        <td class="medium_column"><?php echo $all_car[$i]["name"]?></td>
                        <td class="medium_column">
                            <ul>
                            <?php 
                                $locs = explode(" ", $all_car[$i]["location"]);
                                for($j = 0; $j < count($locs) - 1; $j++):   
                            ?>
                                <li><?php echo $locs[$j]; ?></li>
                            <?php endfor;?>  
                            </ul>
                        </td>
                        <td class="small_column"><?php echo $all_car[$i]["passengers"]?></td>
                        <td><img style="width:200px; height:130px" src="<?php echo $all_car[$i]["main_image"]?>" alt ="<?php echo $all_car[$i]["name"]?>"></td>
                        <td>
                            <?php 
                                $imgs = explode(" ", $all_car[$i]["images"]);
                                for($j = 0; $j < count($imgs) - 1; $j++):   
                            ?>
                                <a target="_blank" class="img_auto_link" href="<?php echo $imgs[$j]; ?>"><?php echo str_replace ("img/", "", $imgs[$j]); ?></a>
                            <?php endfor;?>                                                      
                        </td>
                        <td class="advantages_column"><?php echo nl2br($all_car[$i]["advantages"])?></td>
                        <td class="medium_column"><?php echo $all_car[$i]["date_time"]?></td>
                        <td class="small_column">
                            <form class="update_car">
                                <input type="hidden" name="id" value="<?php echo $all_car[$i]["id"]?>">
                                <?php 
                                    $checkbox = '<input type="checkbox" class="update_car_showing" name="is_showing" ';
                                    $checkbox .= $all_car[$i]["show_car"] == 1 ? 'checked>' : '>'; 
                                    echo $checkbox;
                                ?>
                            </form>
                        </td>
                        <td>
                            <a id="edit_car" class="edit_button edit_car another">Редагувати</a>
                            <form class="delete_form_a">
                                <input type="hidden" name="id" value="<?php echo $all_car[$i]["id"]?>">
                            </form>
                            <a class="delete_button del_car">Видалити</a>
                        </td>  
                    </tr>
                    <?php endfor;?>
                </table>
            </div>
        </div>
    </div>

    <div id="id-edit_phone" class="tabcontent">
        <div class="form_container">
            <form class="edit_phone_form"> 
                <input type="hidden" name="id"> 
                <input type="tel" class="phone" name="phone" required> 
                <div>
                    <h2>Оператор</h2>
                    <select name="operator" required>
                        <?php for($i = 0; $i < count($converted_phone_operators); $i++): ?>
                            <option value="<?php echo strtolower($converted_phone_operators[$i]["name"]); ?>"><?php echo $converted_phone_operators[$i]["name"]; ?></option>
                        <?php endfor;?>
                    </select>  
                </div>            
                <div>
                    <h2>Соціальні мережі</h2>
                    <select name="social_media[]" multiple required>
                        <option value=" ">-Нічого-</option>
                        <?php for($i = 0; $i < count($converted_phone_social_media); $i++): ?>
                            <option value="<?php echo strtolower($converted_phone_social_media[$i]["name"]); ?>"><?php echo $converted_phone_social_media[$i]["name"]; ?></option>
                        <?php endfor;?>
                    </select>  
                </div>             
                <div class="submit_block">
                    <button type="submit" class="add_button">Відредагувати</button>
                    <a id="edit_contacts" class="add_button another" data-text="Редагувати контакти">Назад</a>
                </div>
            </form>
        </div>
    </div>

    <div id="id-edit_email" class="tabcontent">
        <div class="form_container">
            <form class="edit_email_form">    
                <input type="hidden" name="id"> 
                <input placeholder="Введіть email..." type="email" name="email" required>
                <div class="submit_block">
                    <button type="submit" class="add_button">Відредагувати</button>
                    <a id="edit_contacts" class="add_button another" data-text="Редагувати контакти">Назад</a>
                </div>
            </form>

        </div>
    </div>

    <div id="id-add_phone" class="tabcontent">
        <div class="form_container">
            <form class="add_phone_form">            
                <input type="tel" class="phone" name="phone" required> 
                <div>
                    <h2>Оператор</h2>
                    <select name="operator" required>
                        <?php for($i = 0; $i < count($converted_phone_operators); $i++): ?>
                            <option value="<?php echo strtolower($converted_phone_operators[$i]["name"]); ?>"><?php echo $converted_phone_operators[$i]["name"]; ?></option>
                        <?php endfor;?>
                    </select>  
                </div>            
                <div>
                    <h2>Соціальні мережі</h2>
                    <select name="social_media[]" multiple required>
                        <option value="" selected>-Нічого-</option>
                        <?php for($i = 0; $i < count($converted_phone_social_media); $i++): ?>
                            <option value="<?php echo $converted_phone_social_media[$i]["name"]; ?>"><?php echo $converted_phone_social_media[$i]["name"]; ?></option>
                        <?php endfor;?>
                    </select>  
                </div>             
                <div class="submit_block">
                    <button type="submit" class="add_button">Додати</button>
                    <a id="edit_contacts" class="add_button another" data-text="Редагувати контакти">Назад</a>
                </div>
            </form>
        </div>
    </div>

    <div id="id-add_email" class="tabcontent">
        <div class="form_container">
            <form class="add_email_form">            
                <input placeholder="Введіть email..." type="email" name="email" required>
                <div class="submit_block">
                    <button type="submit" class="add_button">Додати</button>
                    <a id="edit_contacts" class="add_button another" data-text="Редагувати контакти">Назад</a>
                </div>
            </form>

        </div>
    </div>

    <div id="id-edit_contacts" class="tabcontent">
        <div class="content_container">
            <div class="table_container">
                <div class="add_block">
                    <div id="add_email" class="another" data-text="Додати Email">
                        <h3>
                            <a class="add_link">Додати Email</a> 
                        </h3> 
                    </div>
                </div>
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
                        <div id="edit_email" data-text="Редагувати Email" class="another">
                            <a class="edit_button edit_email">Редагувати</a>
                        </div>
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
                <div class="add_block">
                    <div id="add_phone" class="another" data-text="Додати телефон">
                        <h3>
                            <a class="add_link">Додати телефон</a> 
                        </h3> 
                    </div>
                </div>
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
                        <td><?php echo ucfirst($row["operator"]);?></td>
                        <td><?php echo ucfirst($row["social_media"])?></td>
                        <td><?php echo $row["date_time"]?></td>
                        <td>
                        <div id="edit_phone" data-text="Редагувати Телефон" class="another">
                            <a class="edit_button edit_phone">Редагувати</a>
                        </div>
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