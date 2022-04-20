<?php
    require __DIR__ . "/utils/bootstrap.php";
    require PROJECT_ROOT_PATH . "/Controllers/Api/UserController.php";

    function cors() {
    
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                // Methods allowed
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
            
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        
            exit(0);
        }
    }

    cors();
    $uriComponents = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode( '/', $uriComponents );

    $route = $uri[2];

    if(isset($route)) {
        switch($route) {
            case 'user':
                $endpointWithoutToken = $uri[3] == "addUser";
                getEndpoint(new UserController(), $uri, $endpointWithoutToken);
            case 'transaction':
                getEndpoint(new BookController(), $uri);
            case 'auth':
                getEndpoint(new AuthorizationController(), $uri, true);
            default:
                header("HTTP/1.1 404 Not Found");
                exit();
        }
    } else {
        header("HTTP/1.1 404 Not Found");
        exit();
    }
?>