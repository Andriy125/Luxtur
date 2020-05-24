<?php
include_once "functions.php";
$folder = "83745893475983756";
$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/' :
        require __DIR__ . '/'. $folder .'/index.php';
        break;
    case '' :
        require __DIR__ . '/'. $folder .'/index.php';
        break;
    case '/admin' :
        if(!isset($_COOKIE["auth"]) or $_COOKIE["auth"] == 0){
            header("Location: /auth");
            exit();
        }
        else if(isset($_COOKIE["auth"]) && $_COOKIE["auth"] == 1){
            require __DIR__ . '/'. $folder .'/admin.php';
        }
        break;
    case '/auth' :
        if(isset($_POST["auth"])){
            $result = authUser();
            if($result){
                header("Location: /admin");
            }
            else{
                header("Location: /auth");
            }
        }
        else if(isset($_POST["logout"])){
            unsetOwnCookie();
            header("Location: /auth");
        }
        else{
            require __DIR__ . '/'. $folder .'/authorization.php';
        }
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/'. $folder .'/404.php';
        break;
}
?>