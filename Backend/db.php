<?php
$dsn = 'mysql:dbname=id12999600_sklep_komputerowy;host=Localhost';
$user = 'id12999600_root';
$pass = '[xVTp\92d|wW661r';
try{
  $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e){
  echo 'Nie udało się połączyć: '.$e->getMessage();
}
?>