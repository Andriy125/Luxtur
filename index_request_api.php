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
    else  if (isset($_POST['e_p_d'])) {
        $id = $_POST["id"];
        // Get text
        $image_text = mysqli_real_escape_string($db, $_POST['text']);
        $sql = "Update popular_directions SET image = '$image', text = '$image_text' WHERE id = ". $id ."";
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
    else if (isset($_POST['e_o_s'])) {
        $id = $_POST["id"];
        // Get text
        $text = mysqli_real_escape_string($db, $_POST['text']);
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $sql = "UPDATE our_service SET image = '$image', title = '$title', text = '$text' WHERE id = ". $id ."";
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
        $sql = "INSERT INTO cars (name, location, passengers, main_image, images, advantages, show_car) VALUES ('$name', '$location', $passengers, '$main_image', '$images', '$advantages', $show_car)";
        // execute query
        mysqli_query($db, $sql);
        if (move_uploaded_file($_FILES['main_image']['tmp_name'], $target)) {
            $msg = "Image uploaded successfully";
        }else{
            $msg = "Failed to upload image";
        }
        header("Refresh:0");
    }
    else if (isset($_POST['edit_car'])) {
        // Get text
        $id = $_POST['id'];
        $name = mysqli_real_escape_string($db, $_POST['name']);
        $location = "";
        $passengers = (int)$_POST['passengers'];
        $show_car = $_POST['show'] == "show" ? 1 : 0;
        $total = count($_FILES['images']['name']);
        $total_locs = count($_POST['location']);
        $main_image = "img/" .  $_FILES["main_image"]["name"];
        $advantages = $_POST['advantages'];
        $target = "img/" . $_FILES["main_image"]["name"];
        $images = "";

        for($i = 0; $i < $total_locs; $i++){
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
        $columns = ['name', 'location', 'passengers', 'main_image', 'images', 'advantages', 'show_car'];
        $value = [strval($name), strval($location), $passengers, strval($main_image), strval($images), strval($advantages), $show_car];
        $data = "";
        for($i = 0; $i < count($columns); $i++){
            $data .= is_string($value[$i]) ? $columns[$i] . " = '" . $value[$i] . "'" : $columns[$i] . " = " . $value[$i];
            if($i != count($columns) - 1){
                $data .= ", ";
            }
        }
        $sql = "UPDATE cars SET $data WHERE id = $id";
        // execute query
        mysqli_query($db, $sql);
        if (move_uploaded_file($_FILES['main_image']['tmp_name'], $target)) {
            $msg = "Image uploaded successfully";
        }else{
            $msg = "Failed to upload image";
        }
        header("Refresh:0");
    }

    mysqli_close($db);
?>