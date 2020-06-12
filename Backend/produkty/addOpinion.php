<?php
date_default_timezone_set('Europe/Warsaw');
session_start();
require('db.php');
if(isset($_POST['opinia'])){
    $select = "SELECT id_klienta FROM klienci WHERE nazwa_uzytkownika = '".$_SESSION['id']."'";
    $result = $pdo -> query($select);
    $row = $result -> fetch(PDO::FETCH_ASSOC);
    $sql = "INSERT INTO opinie(id_produktu, id_klienta, data, tresc) VALUES(?, ?, ?, ?)";
    $result2 = $pdo-> prepare($sql);
    $result2 -> bindValue(1, $_POST['id']);
    $result2 -> bindValue(2, $row['id_klienta']);
    $result2 -> bindValue(3, date("y-m-d H:i:s"));
    $result2 -> bindValue(4, $_POST['opinia']);
    $result2 -> execute();
    echo '<a href=../mainPage.php>Dodano opinię. Kliknij, by powrócić na stronę główną.</a>';
    exit;
}
header("location:../mainPage.php?Error".urlencode("Coś poszło nie tak"));
?>