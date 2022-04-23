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
    <h1>Spectar - dodaj transakcje</h1>
    <?php
        if(isset($_POST['file_name'])) {
            $data = file_get_contents($_POST['file_name'].".json");

            $dataForPOST = array('data' => $data);
            $token = $_SESSION['user']->token;
            $url = 'http://localhost:9000/api/transaction/addByJson';
            $authorization = "Authorization: Bearer $token";
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $dataForPOST);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data; ' , $authorization));
            curl_setopt($curl, CURLOPT_URL, $url);

            try {
                $result = curl_exec($curl);
                echo $result;
            } catch (\Throwable $th) {
                echo $th;
                return null;
            } finally {
                curl_close($curl);
            }
        }
    ?>
    <form method="post" action="addTransaction.php">
        <table>
            <tr>
                <td><label for="currency">Nazwa pliku:</label></td>
                <td><input required type="text" name="file_name" id="login" value="import_data" size="40"/></td>
            </tr>
        </table>
        <input type="submit" id="submit" value="Importuj z pliku">
    </form>
</body>
</html>