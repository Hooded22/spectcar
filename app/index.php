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
    <h1>Spectar</h1>
    <h2>Podstawowe dane: </h2>
    <ul>
        <li><a href="allData.php">Cała tabela</a></l1>
        <li><a href="top10perYear.php">Top 10 transakcji w wybranym roku</a></l1>
        <li><a href="top10PerAge.php">Top 10 transakcji w dla klienta w danym wieku</a></l1>
        <li><a href="top10PerCity.php">Top 10 transakcji w dla wybranego miasta</a></l1>
        <li><a href="top10PerGender.php">Top 10 transakcji w dla klienta o wybranej płci</a></l1>
    </ul>
    <h2>Rozszerzone dane: </h2>
    <ul>
        <li><a href="carValueInYears.php">Wartość samochodu na przestrzeni x lat</a></l1>
    </ul>
</body>
</html>