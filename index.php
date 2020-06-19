<?php
include_once "functions.php";                                       //  import functions
$folder = "83745893475983756";                                      //  random folder name (because user can get file by folder like 'views')
$request = $_SERVER['REQUEST_URI'];                                 //  url request

switch ($request) {
    case '/':
    case '':
        require __DIR__ . '/'. $folder .'/index.php';               //  load index.php
        break;
    case '/admin' :
                                                                    //  go to admin panel
        if(!isset($_COOKIE["auth"]) or $_COOKIE["auth"] == 0){      //  if auth boolean == unauth or not set
            header("Location: /auth");                              //  redirect to auth
            exit();
        }
        else if(isset($_COOKIE["auth"]) && $_COOKIE["auth"] == 1){
            require __DIR__ . '/'. $folder .'/admin.php';           //  if cookie there is - give access to admin panel
        }
        break;
    case '/auth' :                                                  //  request to auth page
        if(isset($_POST["auth"])){                                  //  if auth cookie there is
            $result = authUser();                                   //  try to auth
            if($result){                                            
                header("Location: /admin");                         //  give access to admin panel
            }
            else{
                header("Location: /auth");                          //  redirect to auth page
            }
        }
        else if(isset($_POST["logout"])){                           //  if entered logout button
            unsetOwnCookie();                                       //  delete cookie
            header("Location: /auth");                              //  redirect to auth page
        }
        else{
            require __DIR__ . '/'. $folder .'/authorization.php';   //  else load auth page
        }
        break;
    case '/index_request_api':                                      //  request to file for upload data to server
        include_once "index_request_api.php";                       //  include code from file
        header("Location: /admin");                                 //  redirect to admin
        break;
    default:
        http_response_code(404);                                    //  by default show 404 page
        require __DIR__ . '/'. $folder .'/404.php';                 //  load 404 page
        break;
}
?>