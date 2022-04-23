<?php
    session_start();
    include "utils.php";
    if(!isset($_SESSION['user'])) {
        header("Location: http://localhost:9001/login.php");
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
    <a href="index.php">Powrót do strony głównej</a>
    <h1>Spectar - top 10 dla wybranego miasta</h1>
    <form method="post" action="top10perCity.php">
            <label for="city">Wybierz miasto</label>
            <select required name="city">
                <?php
                    $cities = json_decode(getFromAPI("/transaction/findAllCities", $_SESSION['user']->token));
                    foreach ($cities as $key => $value) {
                        echo "<option value=".$value->transaction_city.">$value->transaction_city</option>";
                    }
                ?>
            </select>
            <input type="submit" id="submit" value="Prześlij">
    </form>
    <?php
        $data = null;
        if(isset($_POST['city'])) {
            $data = json_decode(getFromAPI("/transaction/findBestSellsByCity/?city=".$_POST['city']."", $_SESSION['user']->token));
        } else {
            $data = json_decode(getFromAPI("/transaction/findBestSellsByCity/", $_SESSION['user']->token));
        }
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
           displayData($data);
        ?>
    </table>
    <?php
        if(isset($_POST['file_name']) && isset($data)) {
            file_put_contents($_POST['file_name'].".json", json_encode($data));
        }
    ?>
    <form method="post" action="top10perCity.php">
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