<?php
require('../../db.php');
if(!empty($_POST['nazwa_produktu']) and !empty($_POST['kategoria']) and !empty($_POST['ilosc']) and !empty($_POST['specyfikacja'])
   and !empty($_POST['opis']) and !empty($_POST['cena']) and !empty($_POST['krotki_opis'])){
       $sql = "UPDATE produkty
               SET nazwa_produktu = :nazwa, kategoria = :kategoria, ilosc = :ilosc, specyfikacja = :spec, opis = :opis,
               cena = :cena, cena_promocyjna = :cena_promocyjna, krotki_opis = :krotki_opis WHERE nazwa_produktu = :nazwa";
       $result = $pdo -> prepare($sql);
       $result -> bindValue(":nazwa", $_POST['nazwa_produktu']);
       $result -> bindValue(":kategoria", $_POST['kategoria']);
       $result -> bindValue(":ilosc", $_POST['ilosc']);
       $result -> bindValue(":spec", $_POST['specyfikacja']);
       $result -> bindValue(":opis", $_POST['opis']);
       $result -> bindValue(":cena", $_POST['cena']);
       if(empty($_POST['cena_promocyjna'])) $result -> bindValue(":cena_promocyjna", NULL);
       else $result -> bindValue(":cena_promocyjna", $_POST['cena_promocyjna']);
       $result -> bindValue(":krotki_opis", $_POST['krotki_opis']);
       $result -> execute();
       if($result -> rowCount() > 0)
        header("Location: panel-glowna.php?Error=".urlencode("Pomyślnie edytowano produkt"));
       else header("Location: panel-glowna.php?Error=".urlencode("Coś poszło nie tak"));
   }
?>