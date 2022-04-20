<?php
class BaseController
{

    protected $database = null;
    protected $GENRES = ['horror','thriller','crime','romance','adventure','classical','manners'];
    protected $ORDER_STATUSES = ['in_progress','pending','open','closed','deadline_exceeded'];
    
    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }

    public function __construct() {
        $this->database = new Database();
    }

    
    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode( '/', $uri );

        return $uri;
    }

   
    protected function getQueryStringParams()
    {
        if(isset($_SERVER['QUERY_STRING'])) {
            return parse_str($_SERVER['QUERY_STRING'], $query);
        } else {
            return '';
        }
        
    }

    
    protected function sendOutput($data, $httpHeaders=array())
    {
        header_remove('Set-Cookie');

        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }

        echo $data;
        exit;
    }

    protected function validateMethod($method) {
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) != $method) {
            $errors = 'Method not supported';
            $errorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            $this->sendOutput(json_encode(array('error' => $errors)), array('Content-Type: application/json', $errorHeader));
            return false;
        }

        return true;
    }

    protected function responseData($data, $errors = "", $errorHeader = "") {
        if($errors) {
            $this->sendOutput(json_encode(array('error' => $errors)), array('Content-Type: application/json', $errorHeader));
            return;
        }
        $this->sendOutput(
            $data,
            array('Content-Type: application/json', 'HTTP/1.1 200 OK')
        );
    }

    protected function addValidation($values) {
        foreach($values as $value) {
            if(!isset($_POST[$value]) || trim($_POST[$value] == '')) {
                $strErrorDesc = "$value is required.";
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                $this->responseData('', $strErrorDesc, $strErrorHeader);
                break;
                return false;
            }
        }

        return true;
    }

    protected function prepare_input($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
}