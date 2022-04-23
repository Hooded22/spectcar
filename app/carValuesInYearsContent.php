<?php
    session_start();
    include "utils.php";
    if(!isset($_SESSION['user'])) {
        header("Location: http://localhost:9001/login.php");
    }

    if(isset($_POST['car_model'])) {
        header("Location: http://localhost:9001/carValuesInYearsContent.php");
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
    <h1>Spectar - wartośc samochodu na przestrzeni lat</h1>
    <form method="post" action="carValuesInYearsContent.php">
            <label for="currency">Wybierz walute</label>
            <select required name="currency" value="USD">
                <option value="USD">USD</option>
                <option value="EUR">EUR</option>
                <option value="UAH">UAH</option>
                <option value="GBP">GBP</option>
            </select>
            <label for="currency">Podaj ilośc lat</label>
            <input required type="number" name="years" id="login" value="4" size="40"/>
            <input type="submit" id="submit" value="Dalej">
    </form>
    <?php
        $data = null;
        $currency = "USD";
        $years = 4;
        if(isset($_POST['currency'])) {
            $currency = $_POST['currency'];
        }
        if(isset($_POST['years'])) {
            $years = $_POST['years'];
        }
        $data = json_decode(getFromAPI("/transaction/findCarValueInMonths/?years=$years&currency=".$currency."&car_model=".$_SESSION['car_model']."&car_make=".$_SESSION['car_make'], $_SESSION['user']->token));
    ?>
    <table>
        <?php
           if($data) {
            $data_vars = get_object_vars($data);

            echo "<thead>";
            foreach ($data_vars as $key => $value) {
                echo "<th>$key</th>";
             }
            echo "<thead>";
            echo "<tbody><tr>";
           
            foreach ($data_vars as $key => $value) {
               echo "<td>$value</td>";
            }
            echo "</tbody></tr>";
            $_SESSION['data_to_export'] = $data;
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
    <form method="post" action="carValuesInYearsContent.php">
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