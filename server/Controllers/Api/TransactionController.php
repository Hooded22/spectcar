<?php
class TransactionController extends BaseController
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
            $transacition = new TransactionModel();
            $responseData = json_encode($transacition->getAll());
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        } finally {
            $this->responseData($responseData, $strErrorDesc, $strErrorHeader);
        }
    }

    public function findBestSellsByDateAction() {

        if(!$this->validateMethod('GET')) {
            return;
        }

        $strErrorDesc = null;
        $strErrorHeader = null;
        $responseData = '';

        try {
            $urlParams = parse_url($_SERVER['REQUEST_URI']);
            $transaction = new TransactionModel();

            parse_str($urlParams['query'],$params);
            $date = $params['date'];
            $date = str_replace("-","/", $date);
            
            $responseData = json_encode($transaction->getBestSalesForDate($date));
            $this->responseData($responseData);

        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        } finally {
            $this->responseData($responseData, $strErrorDesc, $strErrorHeader);
        }
    }

    public function findBestSellsByClientAgeAction() {

        if(!$this->validateMethod('GET')) {
            return;
        }

        $strErrorDesc = null;
        $strErrorHeader = null;
        $responseData = '';

        try {
            $urlParams = parse_url($_SERVER['REQUEST_URI']);
            $transaction = new TransactionModel();

            parse_str($urlParams['query'],$params);
            $age = $params['age'];
            
            $responseData = json_encode($transaction->getBestSalesForAge($age));
            $this->responseData($responseData);

        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        } finally {
            $this->responseData($responseData, $strErrorDesc, $strErrorHeader);
        }
    }

    public function findBestSellsByClientGenderAction() {
        if(!$this->validateMethod('GET')) {
            return;
        }

        $strErrorDesc = null;
        $strErrorHeader = null;
        $responseData = '';

        try {
            $urlParams = parse_url($_SERVER['REQUEST_URI']);
            $transaction = new TransactionModel();

            parse_str($urlParams['query'],$params);
            $gender = $params['gender'];
            
            $responseData = json_encode($transaction->getBestSalesForGender($gender));
            $this->responseData($responseData);

        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        } finally {
            $this->responseData($responseData, $strErrorDesc, $strErrorHeader);
        }
    }

    public function findBestSellsByCityAction() {
        if(!$this->validateMethod('GET')) {
            return;
        }

        $strErrorDesc = null;
        $strErrorHeader = null;
        $responseData = '';

        try {
            $urlParams = parse_url($_SERVER['REQUEST_URI']);
            $transaction = new TransactionModel();

            if(isset($urlParams['query'])) {
                parse_str($urlParams['query'],$params);
                $city = $params['city'];

                $responseData = json_encode($transaction->getBestSalesForCity($city, 10));
            } else {
                $result = $transaction->getAllCitiesData();
                $responseData = [];
                while($row = $result->fetch_assoc()) {
                    $responseData = array_merge(
                        $responseData,
                        $transaction->getBestSalesForCity($row['transaction_city'], 1)
                    );
                }
                $this->responseData(json_encode($responseData));
            }

        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        } finally {
            $this->responseData($responseData, $strErrorDesc, $strErrorHeader);
        }
    }

    public function findProfitByCityAction() {
        if(!$this->validateMethod('GET')) {
            return;
        }

        $strErrorDesc = null;
        $strErrorHeader = null;
        $responseData = '';

        try {
            $urlParams = parse_url($_SERVER['REQUEST_URI']);
            $transaction = new TransactionModel();
            
            $responseData = json_encode($transaction->getProfitByCity());
            $this->responseData($responseData);

        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        } finally {
            $this->responseData($responseData, $strErrorDesc, $strErrorHeader);
        }
    }

    public function findAllCitiesAction() {
        if(!$this->validateMethod('GET')) {
            return;
        }

        $strErrorDesc = null;
        $strErrorHeader = null;
        $responseData = '';

        try {
            $urlParams = parse_url($_SERVER['REQUEST_URI']);
            $transaction = new TransactionModel();
            
            $responseData = json_encode($transaction->getAvailableCities());
            $this->responseData($responseData);

        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        } finally {
            $this->responseData($responseData, $strErrorDesc, $strErrorHeader);
        }
    }

    public function addByJsonAction() {

        if(!$this->validateMethod('POST')) {
            return;
        }

        $transactionJson = json_decode($_POST['data'], true);
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        try {
            $transaction = new TransactionModel();
            $responseData = json_encode($transaction->addTransaction($transactionJson));
            $this->responseData($responseData);
            echo "Added successfully";

        } catch (Error $e) {
            $responseData = "ERROR";
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            $this->responseData($responseData, $strErrorDesc, $strErrorHeader);
        }
    }
}