<?php
session_start();
$email = $_POST['email'];
$password = $_POST['password'];
require('db.php');
$sql = "SELECT id_klienta, nazwa_uzytkownika, haslo FROM klienci WHERE email=:email";
$pdo -> setAttribute(PDO::ERRMODE_WARNING, PDO::ERRMODE_EXCEPTION);

$result = $pdo->prepare($sql);
$result->bindValue(":email", $email);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);

$sqlk = "SELECT id_koszyka FROM koszyk WHERE id_klienta=:id";
$resultk = $pdo -> prepare($sqlk);
$resultk -> bindValue(":id", $row['id_klienta']);
$resultk -> execute();
$rowk = $resultk -> fetch(PDO::FETCH_ASSOC);

if($row != false){
    if(password_verify($password, $row['haslo'])){
        $_SESSION['id'] = $row['nazwa_uzytkownika'];
        //przerzucanie produktów w koszyku, w przypadku, gdy użytkownik nie jest zalogowany
        $sql = "SELECT id_produktu, ilosc, cena FROM produkty_w_koszyku WHERE id_koszyka=:id";
        $result3 = $pdo -> prepare($sql);
        $result3 -> bindValue(":id",$_SESSION['temp_koszyk']);
        $result3 -> execute();
        $sql2 = "INSERT INTO produkty_w_koszyku(id_koszyka, id_produktu, ilosc, cena) VALUES(?, ?, ?, ?)";
        while($row3 = $result3->fetch(PDO::FETCH_ASSOC)){
          $result2 = $pdo -> prepare($sql2);
          $result2 -> bindValue(1, $rowk['id_koszyka']);
          $result2 -> bindValue(2, $row3['id_produktu']);
          $result2 -> bindValue(3, $row3['ilosc']);
          $result2 -> bindValue(4, $row3['cena']);
          $result2 -> execute();
        }
        $sql = "DELETE FROM produkty_w_koszyku WHERE id_koszyka=?";
        $result = $pdo -> prepare($sql);
        $result -> bindValue(1, $_SESSION['temp_koszyk']);
        $result -> execute();
        $sql = "DELETE FROM koszyk WHERE id_temp=?";
        $result = $pdo -> prepare($sql);
        $result -> bindValue(1, $_SESSION['temp']);
        $result -> execute();
        unset($_SESSION['temp']);
        unset($_SESSION['temp_koszyk']);
        header("Location: mainPage.php");
        exit;
    }
    else{
      header("location: logowanie.php?Error=".urlencode("Niepoprawne dane logowania"));
      exit;
    }
}
else{
  $sql = "SELECT nazwa_uzytkownika, haslo FROM admin WHERE email = :email";

  $result = $pdo -> prepare($sql);
  $result -> bindValue(":email",$email);
  $result -> execute();
  $row = $result -> fetch(PDO::FETCH_ASSOC);

  if($row != false){
    if(password_verify($password, $row['haslo'])){
        $_SESSION['admin'] = $row['nazwa_uzytkownika'];
        header("Location: admin/pages/panel-glowna.php");
        exit;
    }
    else{
      header("location: logowanie.php?Error=".urlencode("Niepoprawne dane logowania"));
      exit;
    }
  }
}
?>