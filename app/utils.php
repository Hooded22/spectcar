<?php
    function getFromAPI($url, $token) {
        return callAPI("GET",$url, false, $token);
    }

    function postToAPI($url, $token) {

    }

    function callAPI($method, $url, $data = false, $token = false) {
        $curl = curl_init();
        $BASE_URL = "http://localhost:9000/api";

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $BASE_URL.$url, http_build_query($data));
        }

        // Optional Authentication:
        if($token) {
            $authorization = "Authorization: Bearer $token";
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization));
        }

        curl_setopt($curl, CURLOPT_URL, $BASE_URL.$url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }

    function displayData($data) {
        if($data) {
            foreach ($data as $key => $value) {
                echo "<tr>";
                    echo "
                        <td>".$value->client_first_name."</td>
                        <td>".$value->client_last_name."</td>
                        <td>".$value->client_age."</td>
                        <td>".$value->client_gender."</td>
                        <td>".$value->transaction_city."</td>
                        <td>".$value->transaction_date."</td>
                        <td>".$value->car_price."</td>
                        <td>".$value->car_model."</td>
                        <td>".$value->car_make."</td>
                        <td>".$value->car_model_year."</td>
                        <td>".$value->car_color."</td>
                    ";
                echo "</tr>";
            }
        } else {
            echo "<h3>No data</h3>";
        }
    }
?>