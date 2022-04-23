<?php
    session_start();
    include "utils.php";
    if(!isset($_SESSION['user'])) {
        header("Location: http://localhost:9001/login.php");
    }

    if(isset($_POST['car_model'])) {
        $_SESSION['car_model'] = $_POST['car_model'];
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
    <form method="post" action="carValueInYears.php">       
                <?php
                    if(isset($_POST['car_make'])) {
                        $cars = json_decode(getFromAPI("/transaction/findAllCarsByMake/?car_make=".$_POST['car_make'], $_SESSION['user']->token));
                        $_SESSION['car_make'] = $_POST['car_make'];

                        echo "<label for='car_model'>Wybierz model</label>";
                        echo "<select required name='car_model'>";
                        
                        foreach ($cars as $key => $value) {
                            echo "<option value=".$value->car_model.">$value->car_model</option>";
                        }
                        echo "</select>";
                    } else {
                        $cars = json_decode(getFromAPI("/transaction/findAllCarsMakes", $_SESSION['user']->token));

                        echo "<label for='car_make'>Wybierz marke</label>";
                        echo "<select required name='car_make'>";
                        
                        foreach ($cars as $key => $value) {
                            echo "<option value=".$value->car_make.">$value->car_make</option>";
                        }
                        
                        echo "</select>";
                    }
                ?>
            <input type="submit" id="submit" value="Dalej">
    </form>
</body>
</html>