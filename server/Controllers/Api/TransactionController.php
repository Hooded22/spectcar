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
            $year = $params['year'];
            
            $responseData = json_encode($transaction->getBestSalesForDate($year));
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

    public function findAllCarsAction() {
        if(!$this->validateMethod('GET')) {
            return;
        }

        $strErrorDesc = null;
        $strErrorHeader = null;
        $responseData = '';

        try {
            $urlParams = parse_url($_SERVER['REQUEST_URI']);
            $transaction = new TransactionModel();
            
            $responseData = json_encode($transaction->getAllCars());
            $this->responseData($responseData);

        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        } finally {
            $this->responseData($responseData, $strErrorDesc, $strErrorHeader);
        }
    }

    public function findAllCarsByMakeAction() {
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
            $car_make = $params['car_make'];

            
            $responseData = json_encode($transaction->getCarsByMake($car_make));
            $this->responseData($responseData);

        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        } finally {
            $this->responseData($responseData, $strErrorDesc, $strErrorHeader);
        }
    }

    public function findAllCarsMakesAction() {
        if(!$this->validateMethod('GET')) {
            return;
        }

        $strErrorDesc = null;
        $strErrorHeader = null;
        $responseData = '';

        try {
            $urlParams = parse_url($_SERVER['REQUEST_URI']);
            $transaction = new TransactionModel();
            
            $responseData = json_encode($transaction->getAllCarsMakes());
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

    public function findCarValueInMonthsAction() {
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
            $car_model = $params['car_model'];
            $car_make = $params['car_make'];
            $currency = $params['currency'];
            $years = $params['years'];
            $currentYear = date('Y');
            
            $carData = $transaction->getAvgCarPrice($car_model, $car_make)[0];
            $currencyRates = $this->getCurrencyRate($currency, $years);

            foreach ($currencyRates as $key => $value) {
                $year = $currentYear - $key;
                $avgPriceInYear = round($carData['avg_price'] / $value,3);
                if($year == $currentYear) {
                    $carData["avg_price_$currency"] = "$avgPriceInYear";
                } else {
                    $carData["avg_price_".$currency."_in_$year"] = "$avgPriceInYear";
                }
            }

            $this->responseData(json_encode($carData));

        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        } finally {
            $this->responseData($responseData, $strErrorDesc, $strErrorHeader);
        }
    }

    private function calculateRatesAvg($currentResult) {
        $rates = $currentResult->rates;
        $sum = 0;
           
        foreach($rates as $rateItem) {
            $sum += $rateItem->mid;
        };

        return $sum / count($rates);
    }

    private function getCurrencyRate($currencyCode, $years) {
        $curl = curl_init();
        $i = 1;
        $result = [];
        $currentYear = date("Y");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);


        while ($i <= $years) {
            $yearForAPI = $currentYear - $i;
            $url = "https://api.nbp.pl/api/exchangerates/rates/A/$currencyCode/$yearForAPI-01-01/$yearForAPI-12-31?format=JSON";
            
            curl_setopt($curl, CURLOPT_URL, $url);
            $currentResult = json_decode(curl_exec($curl));

            array_push($result, $this->calculateRatesAvg($currentResult));

            $i++;
        }

        $today = date("Y-m-d");
        $urlForCurrentYear = "https://api.nbp.pl/api/exchangerates/rates/A/$currencyCode/$currentYear-01-01/$today?format=JSON";

        curl_setopt($curl, CURLOPT_URL, $urlForCurrentYear);
        $currentYearRates = json_decode(curl_exec($curl));

        array_push($result, $this->calculateRatesAvg($currentYearRates));


        curl_close($curl);

        return $result;
    }
}