<?php
define("PROJECT_ROOT_PATH", __DIR__ . "/../");

// include main configuration file
require_once PROJECT_ROOT_PATH . "/utils/config.php";

// include the base controller file
require_once PROJECT_ROOT_PATH . "/Controllers/Api/BaseController.php";
require_once PROJECT_ROOT_PATH . "/Controllers/Api/TransactionController.php";
require_once PROJECT_ROOT_PATH . "/Controllers/Api/AuthorizationController.php";

// include the use model file
require_once PROJECT_ROOT_PATH."/Models/Database.php";
require_once PROJECT_ROOT_PATH . "/Models/UserModel.php";
require_once PROJECT_ROOT_PATH . "/Models/TransactionModel.php";

require_once PROJECT_ROOT_PATH . "/utils/utils.php";


?>