<?php
    $con = mysqli_connect('localhost', 'root', '', 'luxtur');
    if (!$con) {
        die('Ошибка соединения: ' . mysql_error());
    }
    $result_phones = mysqli_query($con, "SELECT * FROM contact_phones");
    $result_emails = mysqli_query($con, "SELECT * FROM contact_emails");
    $result_reviews = mysqli_query($con, "SELECT * FROM review");
    $sort_review_options = mysqli_query($con, "SHOW COLUMNS FROM review");
    $sort_order_options = mysqli_query($con, "SHOW COLUMNS FROM orders");
    $result_orders = mysqli_query($con, "SELECT * FROM orders");
    $result_calls = mysqli_query($con, "SELECT * FROM calls");
    $result_popular_directions = mysqli_query($con, "SELECT * FROM popular_directions");
    $result_our_services = mysqli_query($con, "SELECT * FROM our_service");

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
    mysqli_close($con);
?>