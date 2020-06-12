<!DOCTYPE html>
<?php 
require("../../db.php");
session_start(); 
if(empty($_SESSION['admin'])) header("Location: ../../mainPage.php?Error=".urlencode("Access denied"));
?>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <title>Panel administracyjny</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="CSS/style2.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="icon" href="obrazki/icon.png">
    </head>
    <body>
    <?php if(isset($_GET['Error'])){
            echo '<script> alert("'.$_GET['Error'].'")</script>';
        }?>
        <header>
            <h1>PANEL ADMINISTRACYJNY</h1>
        </header>
        <nav>
            <ul>
                <li><a href="panel-glowna.php">Lista produktów</a></li>
                <li><a href="panel-zamowienia.php">Lista zamówień</a> </li>
                <li><a href="../../mainPage.php">Powróć do sklepu</a></li>
            </ul>
        </nav>
        <div class="content">
            <?php
            $sql = "SELECT id_zamowienia, imie, nazwisko, miasto, adres, kod_pocztowy, wartosc_zamowienia, sposob_dostawy
                    FROM klienci k JOIN zamowienia z ON (k.id_klienta = z.id_klienta)";
            $result = $pdo -> prepare($sql);
            $result -> execute();
                while($row = $result -> fetch(PDO::FETCH_ASSOC)){
                    echo '<div class="card zamowienie"> <div class="card-body">';
                    echo '<h5 class="card-title">Zamówienie ID #'.$row['id_zamowienia'].'</h5>';
                    echo '<p>Imię i nazwisko: '.$row['imie'].' '.$row['nazwisko'].'</p>';
                    echo '<p>Adres: '.$row['adres'].'</p>';
                    echo '<p>Miasto: '.$row['miasto'].'</p>'; 
                    echo '<p>Wartość zamówienia: '.$row['wartosc_zamowienia'].'</p>';
                    echo '<p>Sposób dostawy: '.$row['sposob_dostawy'].'</p></div></div>';
                }
            ?>
        </div>
    </body>
</html>