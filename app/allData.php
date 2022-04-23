<?php
    session_start();
    include "utils.php";
    if(!isset($_SESSION['user'])) {
        header("Location: http://localhost:9001/login.php");
    }
    
    function getAllData() {
        getFromAPI("/transaction/findAll", $_SESSION['user']->token);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Spectar - cala tabela</h1>
    <?php
        $data = json_decode(getFromAPI("/transaction/findAll", $_SESSION['user']->token));
    ?>
    <table>
        <thead>
            <th>client_first_name</th>
            <th>client_last_name</th>
            <th>client_age</th>
            <th>client_gender</th>
            <th>transaction_city</th>
            <th>transaction_date</th>
            <th>car_price</th>
            <th>car_model</th>
            <th>car_make</th>
            <th>car_model_year</th>
            <th>car_color</th>
        </thead>
        <?php
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
        ?>
    </table>
    <?php
        if(isset($_POST['file_name']) && isset($data)) {
            file_put_contents($_POST['file_name'].".json", json_encode($data));
        }
    ?>
    <form method="post" action="allData.php">
        <table>
            <tr>
                <td><label for="currency">Nazwa pliku</label></td>
                <td><input required type="text" name="file_name" id="login" value="export_result" size="40"/></td>
            </tr>
        </table>
        <input type="submit" id="submit" value="Exportuj do JSON">
    </form>
</body>
</html>