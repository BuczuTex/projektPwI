<?php
require("../../db.php");
session_start();
if(!empty($_SESSION['temp_koszyk'])){
    $sql = "SELECT pk.id_produktu, nazwa_produktu, cena FROM produkty_w_koszyku pk 
            JOIN produkty p ON (p.id_produktu = pk.id_produktu) WHERE id_koszyka=?";
    $cenaK = 0;
    $produkty = array();
    $result = $pdo -> prepare($sql);
    $result -> bindValue(1, $_SESSION['temp_koszyk']);
    $result -> execute();
    while($row = $result -> fetch()){
    $cenaK += $row['cena'];
    array_push($row['id_produktu'],$row['nazwa_produktu']); 
    }
    $sql = "DELETE FROM produkty_w_koszyku WHERE id_koszyka=?";
    $result = $pdo -> prepare($sql);
    $result -> bindValue(1, $_SESSION['temp_koszyk']);
    $result -> execute();
    $sql = "DELETE FROM koszyk WHERE id_koszyka=?";
    $result = $pdo -> prepare($sql);
    $result -> bindValue(1, $_SESSION['temp_koszyk']);
    $result -> execute();
    $msg="";
    foreach($produkty as $row){
        $msg += $row + "\t";
    }
    $msg += $cenaK + " "+$_SESSION['admin'];
    unset($_SESSION['temp_koszyk']);
    mail("example@example.com","Zobowiązanie do zapłaty za produkty",$msg);
    header("location: panel-glowna.php?Error=".urlencode("Zamówiono produkty"));
}
else header("location: panel-glowna.php?Error=".urlencode("Coś poszło nie tak"));
?>