<?php
include 'koszyk.php';
$select2 = "SELECT id_klienta FROM klienci WHERE nazwa_uzytkownika='".$_SESSION['id']."'";
$result2 = $pdo->query($select2);
$row2 = $result2 -> fetch(PDO::FETCH_ASSOC);
$sql2 = "DELETE FROM produkty_w_koszyku WHERE id_koszyka = (SELECT id_koszyka FROM koszyk WHERE id_klienta=?)";
$res2 = $pdo -> prepare($sql2);
$res2 -> bindValue(1, $row2['id_klienta']);
$res2 -> execute();
?>