<?php
session_start();
$email = $_POST['email'];
$password = $_POST['password'];
$dsn = 'mysql:dbname=id12999600_sklep_komputerowy;host=hostname';
$user = 'id12999600_root';
$sql = "SELECT nazwa_uzytkownika, haslo FROM klienci WHERE email=:email";

try{
  $pdo = new PDO($dsn, $user);
} catch (PDOException $e){
  echo 'Nie udało się połączyć: '.$e->getMessage();
}

$result = $pdo->prepare($sql);
$result->bindValue(":email", $email);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);

if($row != false){
    if(password_verify($password, $row['haslo'])){
        $_SESSION['id'] = $row['nazwa_uzytkownika'];
        header("Location: mainPage.php");
        exit;
    }
    else{
      header("location: logowanie.php?Error=".urlencode("Niepoprawne dane logowania"));
      exit;
    }
}
else header("location: logowanie.php?Error=".urlencode("Niepoprawne dane logowania"));
?>