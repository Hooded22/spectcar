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
    <h1>Spectar - top 10 dla wybranego roku</h1>
    <form method="post" action="top10perAge.php">
            <label for="age">Podaj wiek klienta</label>
            <input required type="number" name="age" id="login" size="40"/>
            <input type="submit" id="submit" value="Prześlij">
    </form>
    <?php
        $data = null;
        $age = 18;
        if(isset($_POST['age'])) {
            $age = $_POST['age'];
        }
        $data = json_decode(getFromAPI("/transaction/findBestSellsByClientAge/?age=".$age."", $_SESSION['user']->token));
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
</body>
</html>