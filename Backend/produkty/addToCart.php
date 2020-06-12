<?php
session_start();
require('../db.php');
if(isset($_GET['ilosc'])){
    if(empty($_SESSION['id'])){
        $_SESSION['temp'] = uniqid(random_int(1, 90000));
        $sql2 = "INSERT INTO koszyk(id_koszyka, id_temp, data) VALUES(?, ?, ?)";
        $result2 = $pdo -> prepare($sql2);
        $koszyk = uniqid(random_int(1, 90000));
        $_SESSION['temp_koszyk'] = $koszyk;
        $result2 -> bindValue(1, $koszyk);
        $result2 -> bindValue(2, $_SESSION['temp']);
        $result2 -> bindValue(3, date("Y-m-d H:i:s"));
        $result2 -> execute();
        $sql2 = "INSERT INTO produkty_w_koszyku(id_koszyka, id_produktu, ilosc, cena) VALUES(?, ?, ?, ?)";
        $result2k = $pdo -> prepare($sql2);
        $result2k -> bindValue(1, $koszyk);
        $result2k -> bindValue(2, $_SESSION['id_produktu']);
        $result2k -> bindValue(3, $_GET['ilosc']);
        if(empty($_SESSION['cena_promocyjna'])) $result2k -> bindValue(4, $_GET['ilosc'] * $_SESSION['cena']);
        else $result2k -> bindValue(4, $_GET['ilosc'] * $_SESSION['cena_promocyjna']);
        $result2k -> execute();
    }
    else{
        $select = "SELECT ko.id_koszyka FROM koszyk ko JOIN klienci k ON (k.id_klienta = ko.id_klienta)
        WHERE nazwa_uzytkownika = '".$_SESSION['id']."'";
        $sql2 = "INSERT INTO produkty_w_koszyku(id_koszyka, id_produktu, ilosc, cena) VALUES(?, ?, ?, ?)";
        $res = $pdo -> query($select);
        $res2 = $res -> fetch(PDO::FETCH_ASSOC);
        $ilosc = $_GET['ilosc'];
        if(!empty($row['cena_promocyjna'])) $cenaK = $ilosc * $_SESSION['cena_promocyjna'];
        else $cenaK = $ilosc * $_SESSION['cena'];
        $koszyk = $pdo -> prepare($sql2);
        $koszyk -> bindValue(1, $res2['id_koszyka']);
        $koszyk -> bindValue(2, $_SESSION['id_produktu']);
        $koszyk -> bindValue(3, $ilosc);
        $koszyk -> bindValue(4, $cenaK);
        $koszyk -> execute();
    }
    unset($_SESSION['cena']);
    unset($_SESSION['cena_promocyjna']);
    unset($_SESSION['id_produktu']);
    header("location: ../produkty.php?Error=".urlencode("Dodano pomyślnie do koszyka!"));
}
?>