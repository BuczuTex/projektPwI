<?php
$dsn = 'mysql:dbname=id12999600_sklep_komputerowy;host=hostname';
$user = 'id12999600_root';
$sql = "SELECT * FROM klienci WHERE email=? OR nazwa_uzytkownika=?";
try{
$pdo = new PDO($dsn, $user);
} catch (PDOException $e){
echo 'Nie udało się połączyć: '.$e->getMessage();
}

if(!empty($_POST['emailReg']) and !empty($_POST['userReg']) and !empty($_POST['hasloReg']) and !empty($_POST['haslo2Reg'])
   and !empty($_POST['imieReg']) and !empty($_POST['nazwiskoReg']) and !empty($_POST['miastoReg']) and !empty($_POST['adresReg'])
   and !empty($_POST['kodReg'])){
        $email = $_POST['emailReg'];
        $user = $_POST['userReg'];
        $haslo = $_POST['hasloReg'];
        $haslo2 = $_POST['haslo2Reg'];
        $imie = $_POST['imieReg'];
        $nazwisko = $_POST['nazwiskoReg'];
        $miasto = $_POST['miastoReg'];
        $adres = $_POST['adresReg'];
        $kodReg = $_POST['kodReg'];
        $result = $pdo->prepare($sql);
        $result -> bindValue(1, $email);
        $result -> bindValue(2, $user);
        $result -> execute();
        $row = $result -> fetch(PDO::FETCH_ASSOC);
        if($row == true) {
                header("Location: logowanie.php?Error=".urlencode("Użytkownik istnieje"));
                exit;
        }
        else if($haslo != $haslo2){ 
                header("Location: logowanie.php?Error=".urlencode("Hasła nie zgadzają się"));
                exit;
        }
        else{
                $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $haslo = password_hash($haslo, PASSWORD_BCRYPT);
                $sql = "INSERT INTO klienci(email,nazwa_uzytkownika,haslo,imie,nazwisko,miasto,adres,kod_pocztowy)
                        VALUES(?,?,?,?,?,?,?,?)";
                $result = $pdo -> prepare($sql);
                $result -> bindValue(1, $email);
                $result -> bindValue(2, $user);
                $result -> bindValue(3, $haslo);
                $result -> bindValue(4, $imie);
                $result -> bindValue(5, $nazwisko);
                $result -> bindValue(6, $miasto);
                $result -> bindValue(7, $adres);
                $result -> bindValue(8, $kodReg);
                $result -> execute();
                header("location: mainPage.php?Error=".urlencode("Pomyślnie zarejestrowano. Można się zalogować."));
                exit;
        }
}
else{
        header("location: logowanie.php?Error=".urlencode("Nie wpisano wszystkich danych"));
}
?>