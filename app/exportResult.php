<?php
    session_start();
    include "utils.php";
    if(!isset($_SESSION['user']) || !isset($_SESSION['data_to_export'])) {
        header("Location: http://localhost:9001/login.php");
    }

   file_put_contents("export.json", json_encode($_SESSION['data_to_export']));
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
    <form method="post" action="exportResult.php">
        <table>
            <tr>
                <td><label for="currency">Nazwa pliku</label></td>
                <td><input required type="text" name="file_name" id="login" value="export_result" size="40"/></td>
            </tr>
        </table>
        <input type="submit" id="submit" value="Export">
    </form>
    <h1>Export wykonany pomyślnie</h1>
</body>
</html>