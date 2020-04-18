<?php
    $con = mysqli_connect('localhost', 'root', '', 'luxtur');
    if (!$con) {
        die('Ошибка соединения: ' . mysql_error());
    }
    $result_phones = mysqli_query($con, "SELECT * FROM contact_phones");
    $result_emails = mysqli_query($con, "SELECT email FROM contact_emails");
    $result_reviews = mysqli_query($con, "SELECT * FROM review");
    $result_orders = mysqli_query($con, "SELECT * FROM orders");
    if (!$result_phones) {
        die('Неверный запрос: ' . $con->sqlstate);
    }
    if (!$result_emails) {
        die('Неверный запрос: ' . $con->sqlstate);
    }
    if (!$result_reviews) {
        die('Неверный запрос: ' . $con->sqlstate);
    }
    if (!$result_orders) {
        die('Неверный запрос: ' . $con->sqlstate);
    }
    mysqli_close($con);
?>