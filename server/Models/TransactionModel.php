<?php
    class TransactionModel extends Database {
        public function getAll() {
            $query = "SELECT * FROM transactions";
            return $this->select($query);
        }

       public function getProfitByCity() {
            $query = "SELECT transaction_city, COUNT(id) as 'transactions_count', AVG(car_price) as 'average_car_price', SUM(car_price) as 'profit_sum' FROM `transactions` GROUP BY transaction_city";
            return $this->select($query);
       }

       public function getBestSalesForCity($city, $limit) {
           $query = "SELECT * FROM `transactions` WHERE transaction_city LIKE '$city' ORDER BY car_price DESC LIMIT $limit";
           return $this->select($query);
       }

       public function getBestSalesForAllCities($cities) {
            
       }

       public function getBestSalesForDate($date) {
            $query = "SELECT * FROM `transactions` WHERE transaction_date LIKE '$date' ORDER BY car_price LIMIT 10";
            return $this->select($query);
       }

       public function getBestSalesForAge($age) {
            $query = "SELECT * FROM `transactions` WHERE client_age = $age ORDER BY car_price LIMIT 10";
            return $this->select($query);
       }

       public function getBestSalesForGender($gender) {
            $query = "SELECT * FROM `transactions` WHERE client_gender LIKE '$gender' ORDER BY car_price LIMIT 10";
            return $this->select($query);
       }

       public function getAvailableCities() {
            $query = "SELECT DISTINCT transaction_city FROM transactions";
            return $this->select($query);
       }

       public function getAllCitiesData() {
         $query = "SELECT DISTINCT transaction_city FROM transactions";
         return $this->executeStatement($query);
       }

       public function addTransaction(
        $transactionJson
       ) {
            $client_first_name = $transactionJson['client_first_name'];
            $client_last_name = $transactionJson['client_last_name'];
            $client_age = $transactionJson['client_age'];
            $client_gender = $transactionJson['client_gender'];
            $transaction_city = $transactionJson['transaction_city'];
            $transaction_date = $transactionJson['transaction_date'];
            $car_price = $transactionJson['car_price'];
            $car_model = $transactionJson['car_model'];
            $car_make = $transactionJson['car_make'];
            $car_model_year = $transactionJson['car_model_year'];
            $car_color = $transactionJson['car_color'];

            $query = "INSERT INTO `transactions`(`id`, `client_first_name`, `client_last_name`, `client_age`, `client_gender`, `transaction_city`, `transaction_date`, `car_price`, `car_model`, `car_make`, `car_model_year`, `car_color`) VALUES (NULL, '$client_first_name', '$client_last_name', '$client_age', '$client_gender', '$transaction_city', '$transaction_date', '$car_price', '$car_model', '$car_make', '$car_model_year', '$car_color')";
            return $this->executeStatement($query);
        }
    }