<?php
class AuthorizationController extends BaseController
{ 
    

    public function loginAction() {
        $userFieldsNames = ['login', 'password'];
        if(!$this->addValidation($userFieldsNames) || !$this->validateMethod('POST')) {
            return;
        }

        try {
            $login = $this->prepare_input($_POST['login']);
            $password = $this->prepare_input($_POST['password']);
            $user = new UserModel();
            $response = $user->getByLogin($login);

            if(!$response || !password_verify($password, $response[0]['password']) ) {
                echo password_hash($password, PASSWORD_BCRYPT);
                throw new Error("Incorect login or password.",);
            }

            $userId = $response[0]['id'];
            $jwt = createJWT($userId);
            $currentDate = date('Y-m-d H:i:s');
            $newExpDate = date('Y-m-d H:i:s', strtotime($currentDate.' + 1 day'));
            $responseData = json_encode($user->updateUser([
                "token" => $jwt,
                "token_expire_date" => $newExpDate
            ], $userId));

           
            $this->responseData($responseData);

        } catch (Error $e) {
            $responseData = "ERROR";
            $strErrorDesc = $e->getMessage();
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }

        $this->responseData($responseData, $strErrorDesc, $strErrorHeader);

    }

    private function tryGetToken() {;
        if(!isset($_SERVER['HTTP_AUTHORIZATION']) || trim($_SERVER['HTTP_AUTHORIZATION']) == '')
        {
            throw new Error("Token not provided");
        } else {
            $baererToken = $_SERVER['HTTP_AUTHORIZATION'];
            $tokenArr = explode(' ', $baererToken);
            $token = $tokenArr[1];
        }
        return $token;
    }

    private function validateToken($token) {
        $user = new UserModel();
        try {
            $usersWithToken = $user->getByToken($token);
            if($usersWithToken != FALSE) {
                $tokenExpireDate = $usersWithToken[0]['token_expire_date'];
                $currentDate = date("Y-m-d H:i:s");
                if($currentDate > $tokenExpireDate) {
                    throw new Error("Token is expired");
                }
                return;
            } else {
                throw new Error("Token incorect");    
            }
        } catch (Error $e) {
            throw $e;
        }
       


    }

    public function authorizeEndpoint() {
        try {
            $token = $this->tryGetToken();
            $this->validateToken($token);
        } catch (Error $e) {
            //echo "TEST";
            $responseData = "";
            $strErrorDesc = $e->getMessage();
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            $this->responseData($responseData, $strErrorDesc, $strErrorHeader);
        }
    }
        
}
