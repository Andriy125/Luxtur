<?php
include_once "functions.php";
$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/' :
        require __DIR__ . '/views/index.php';
        break;
    case '' :
        require __DIR__ . '/views/index.php';
        break;
    case '/admin' :
        if(!isset($_COOKIE["auth"]) or $_COOKIE["auth"] == 0){
            header("Location: /auth");
            exit();
        }
        else if($_COOKIE["auth"] == 1){
            require __DIR__ . '/views/admin.php';
        }
        break;
    case '/auth' :
        if(isset($_POST["auth"])){
            $result = authUser();
            if($result){
                setcookie("auth", 1, time() + 3600 * 24);
                header("Location: /admin");
            }
            else{
                setcookie("auth", 0, time() - 3600 * 24);
                header("Location: /auth");
            }
        }
        else if(isset($_POST["logout"])){
            setcookie("auth", 0, time() - 3600 * 24);
            header("Location: /auth");
        }
        else{
            require __DIR__ . '/views/authorization.php';
        }
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}
?>