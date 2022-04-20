<?php
class UserController extends BaseController
{
    public function findAllAction()
    {
        if(!$this->validateMethod('GET')) {
            return;
        }

        $strErrorDesc = null;
        $strErrorHeader = null;
        $responseData = '';

        try {
            $user = new UserModel();
            $responseData = json_encode($user->getAllUsers());
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        } finally {
            $this->responseData($responseData, $strErrorDesc, $strErrorHeader);
        }   
    }

    public function findByIdAction() {
        if(!$this->validateMethod('GET')) {
            return;
        }

        $strErrorDesc = null;
        $strErrorHeader = null;
        $responseData = '';

        try {
            $urlParams = parse_url($_SERVER['REQUEST_URI']);
            $user = new UserModel();

            parse_str($urlParams['query'],$params);
            $id = $params['id'];
            
            $responseData = json_encode($user->getById($id));
            $this->responseData($responseData);

        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        } finally {
            $this->responseData($responseData, $strErrorDesc, $strErrorHeader);
        }
    }

    private function userWithLoginExist($login) {
       try {
            $user = new UserModel();
            $response = $user->getByLogin($login);
            return $response != false;
            
        } catch (Error $e) {
            return $e;
        }

        return "ELO";
    }

    private function addUserValidation($values) {
        foreach($values as $value) {
            if(!isset($_POST[$value]) || trim($_POST[$value] == '')) {
                $strErrorDesc = "$value is required.";
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                $this->responseData('', $strErrorDesc, $strErrorHeader);
                break;
                return false;
            }
        }

        if(!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
            $strErrorDesc = "Incorect email";
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            $this->responseData('', $strErrorDesc, $strErrorHeader);
            return false;
        }

        $userWithLogin = $this->userWithLoginExist($_POST['login']);
        if($userWithLogin == true) {
            $strErrorDesc = "User with this login already exist";
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            $this->responseData('', $strErrorDesc, $strErrorHeader);
            return false;
        }

        return true;
    }

    public function addUserAction() {
        $userFieldsNames = ['login','email','name', 'last_name', 'password'];

        if(!$this->addUserValidation($userFieldsNames) || !$this->validateMethod('POST')) {
            return;
        }

        $login = $this->prepare_input($_POST['login']);
        $email = $this->prepare_input($_POST['email']);
        $name = $this->prepare_input($_POST['name']);
        $lastName = $_POST['last_name'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        try {
            $user = new UserModel();
            $user->addUser($login, $email, $name, $lastName, $password);
            $responseData = "SUCCESS";
            $this->responseData($responseData);
        } catch (Error $e) {
            $responseData = "ERROR";
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            $this->responseData($responseData, $strErrorDesc, $strErrorHeader);
        }

        
    }

    public function updateUserAction() {
        $userFieldsNames = ['login','email','name', 'last_name', 'type'];
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $values = [];

        if(!$this->validateMethod("POST") || !isset($_POST['id'])) {
            $strErrorDesc = $_POST[0];
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            $this->responseData('', $strErrorDesc, $strErrorHeader);
            return;
        }

        foreach($userFieldsNames as $value) {
            if(isset($_POST[$value]) && trim($_POST[$value]) != '') {
                $newElement = $values[$value] = $_POST[$value];
            }
        }

        
        try {
            $id = $_POST['id'];
            $user = new UserModel();
            $response = $user->updateUser($values, $id);
            $responseData = json_encode($response);

            $this->responseData($responseData);

        } catch (Error $e) {
            $responseData = "ERROR";
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }

        $this->responseData($responseData, $strErrorDesc, $strErrorHeader);
    }

    public function getExpiredOrdersAction() {
        if(!$this->validateMethod('GET')) {
            return;
        }

        $strErrorDesc = null;
        $strErrorHeader = null;
        $responseData = '';

        try {
            $urlParams = parse_url($_SERVER['REQUEST_URI']);
            parse_str($urlParams['query'],$params);
            $id = $params['id'];
            $order = new OrderModel();
            $responseData = json_encode($order->findExpiredByUserId($id));
            $this->responseData($responseData);

        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        } finally {
            $this->responseData($responseData, $strErrorDesc, $strErrorHeader);
        }
    }

}