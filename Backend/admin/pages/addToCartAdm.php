<?php
require('../../db.php');
session_start();
if(!empty($_POST['id_adm']) and !empty($_SESSION['admin'])){
    $_POST['id_adm'] = str_replace("adm","",$_POST['id_adm']);
    if(empty($_SESSION['temp']) or empty($_SESSION['temp_koszyk'])){
        $_SESSION['temp'] = uniqid(random_int(1, 90000));
        $sql2 = "SELECT id_produktu, cena, cena_promocyjna FROM produkty WHERE id_produktu=?";
        $result2 = $pdo->prepare($sql2);
        $result2 -> bindValue(1, $_POST['id_adm']);
        $result2 -> execute();
        $row2 = $result2 -> fetch(PDO::FETCH_ASSOC);
        $sql = "INSERT INTO koszyk(id_koszyka, id_temp, data) VALUES(?, ?, ?)";
        $result = $pdo -> prepare($sql);
        $_SESSION['temp_koszyk'] = uniqid(random_int(1, 90000));
        $result -> bindValue(1, $_SESSION['temp_koszyk']);
        $result -> bindValue(2, $_SESSION['temp']);
        $result -> bindValue(3, date("Y-m-d H:i:s"));
        $result -> execute();
        $row = $result -> fetch(PDO::FETCH_ASSOC);
        $sql = "INSERT INTO produkty_w_koszyku(id_koszyka, id_produktu, ilosc, cena) VALUES(?, ?, 1, ?)";
        $result3 = $pdo -> prepare($sql);
        $result3 -> bindValue(1, $_SESSION['temp_koszyk']);
        $result3 -> bindValue(2, $row2['id_produktu']);
        if(empty($row2['cena_promocyjna'])) $result3 -> bindValue(3, $row2['cena']);
        else $result3->bindValue(3, $row2['cena_promocyjna']);
        $result3 -> execute();
        $sql = "UPDATE admin SET id_temp = ? WHERE nazwa_uzytkownika = ?";
        $result3 = $pdo -> prepare($sql);
        $result3 -> bindValue(1, $_SESSION['temp_koszyk']);
        $result3 -> bindValue(2, $_SESSION['admin']);
        $result3 -> execute();
        echo "Dodano. Proszę się nie wylogowywać.";
    }
    else{
        $sql2 = "SELECT id_produktu, cena, cena_promocyjna FROM produkty WHERE id_produktu=?";
        $result2 = $pdo->prepare($sql2);
        $result2 -> bindValue(1, $_POST['id_adm']);
        $result2 -> execute();
        $row2 = $result2 -> fetch(PDO::FETCH_ASSOC);
        $sql = "INSERT INTO produkty_w_koszyku(id_koszyka, id_produktu, ilosc, cena) VALUES(?, ?, 1, ?)";
        $result3 = $pdo -> prepare($sql);
        $result3 -> bindValue(1, $_SESSION['temp_koszyk']);
        $result3 -> bindValue(2, $row2['id_produktu']);
        if(empty($row2['cena_promocyjna'])) $result3 -> bindValue(3, $row2['cena']);
        else $result3->bindValue(3, $row2['cena_promocyjna']);
        $result3 -> execute();
        echo "Dodano";
    }
}
else "Coś poszło nie tak";
?>