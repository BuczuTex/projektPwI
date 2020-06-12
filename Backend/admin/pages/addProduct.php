<?php
require("../../db.php");
if(!empty($_POST['nazwa_produktu2']) and !empty($_POST['kategoria_produktu2']) and !empty($_POST['ilosc2'])
    and !empty($_POST['specyfikacja2']) and !empty($_POST['opis2']) and !empty($_POST['cena2']) and !empty($_POST['krotki_opis2'])
    and !empty($_POST['alt2']) and $_FILES['zdjecie']['error'] <= 0){
        $sql = "INSERT INTO produkty(nazwa_produktu, kategoria, ilosc, specyfikacja, opis, cena, cena_promocyjna, zdjecie, 
                krotki_opis, alt) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $result = $pdo -> prepare($sql);
        $target = "/public_html/Frontend/obrazki/produkty";
        $max = 10000000;
        if(is_uploaded_file($_FILES['zdjecie']['tmp_name'])){
            if($_FILES['zdjecie']['size'] > $max){
                header("location: panel-glowna.php?Error=".urlencode("Plik jest za duży. 10 MB maksymalnie"));
                exit;
            }
            $control = getimagesize($_FILES['zdjecie']['tmp_name']);
            if($control != false){
                $name = basename($_FILES['zdjecie']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($_FILES['zdjecie']['tmp_name'], "C:/xampp/htdocs$target/$name");
                $result -> bindValue(8, "$target/$name");
            }
            else {
                header("location: panel-glowna.php?Error=".urlencode("Plik nie jest zdjęciem"));
                exit;
        }
    }
        $pdo -> setAttribute(PDO::ERRMODE_WARNING, PDO::ERRMODE_EXCEPTION);
        $alt = '"'.$_POST['alt2'].'"';
        $result -> bindValue(1, $_POST['nazwa_produktu2']);
        $result -> bindValue(2, $_POST['kategoria_produktu2']);
        $result -> bindValue(3, $_POST['ilosc2']);
        $result -> bindValue(4, $_POST['specyfikacja2']);
        $result -> bindValue(5, $_POST['opis2']);
        $result -> bindValue(6, $_POST['cena2']);
        if(empty($_POST['cena_promocyjna2'])) $result -> bindValue(7, NULL);
        else $result -> bindValue(7, $_POST['cena_promocyjna2']);
        $result -> bindValue(9, $_POST['krotki_opis2']);
        $result -> bindValue(10, $alt);
        $result -> execute();
        header("location: panel-glowna.php?Error=".urlencode("Pomyślnie dodano produkt"));
}
else header("location: panel-glowna.php?Error=".urlencode("Coś poszlo nie tak"));
?>