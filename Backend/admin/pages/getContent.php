<?php
require('../../db.php');
if(!empty($_POST['mod_id'])){
    $id = str_replace("pr","",$_POST['mod_id']);
    $sql = "SELECT nazwa_produktu, kategoria, ilosc, specyfikacja, opis, cena, cena_promocyjna, krotki_opis FROM produkty WHERE id_produktu = :id";
    $arr = array(
        "nazwa_produktu" => "Nazwa produktu",
        "kategoria" => "Kategoria produktu",
        "ilosc" => "Proszę podać ilość",
        "specyfikacja" => "Proszę podać specyfikację produktu",
        "opis" => "Proszę podać opis produktu",
        "cena" => "Proszę podać cenę produktu",
        "cena_promocyjna" => "Proszę podać cenę promocyjną produktu (jeśli jest promocja)",
        "krotki_opis" => "Proszę podać krótki opis produktu (widoczny np. na stronie produkty). Delimiter: /"
    );
    $length = array(
        "nazwa_produktu" => 100,
        "kategoria" => 30,
        "specyfikacja" => 65535,
        "opis" => 65535,
        "krotki_opis" => 300
    );
    $result = $pdo -> prepare($sql);
    $result -> bindValue(":id", $id);
    $result -> execute();
    if($result -> rowCount() > 0){
        $row = $result -> fetch(PDO::FETCH_ASSOC);
        echo '<form method="POST" action="edit.php">';
        foreach($row as $key => $value){
            echo '<div class="form-group"> 
                  <label for="'.$key.'">'.$arr[$key].'</label>';
            if($key == "specyfikacja" or $key == "opis" or $key == "krotki_opis") 
                echo '<textarea rows="10" cols="50" id="'.$key.'" name = "'.$key.'"maxlength = "'.$length[$key].'">
                '.$row[$key].'</textarea> </div>';
            else if($key == 'ilosc' or $key == 'cena' or $key == 'cena_promocyjna'){
                echo '<input type = "number" class="form-control" id="'.$key.'" value="'.$row[$key].'" name="'.$key.'"min = "0" 
                max="10000000000"';
                if($key != 'cena_promocyjna') echo 'required>';
                echo '</div>';
            }
            else echo '<input type = "text" class="form-control" id="'.$key.'" value="'.$row[$key].'" name="'.$key.'" maxlength="'.
            $length[$key].'"> </div>';
        }
        echo '<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj zmiany</button>
        <button type="submit" class="btn btn-primary">Zatwierdź zmiany</button>
        </div>';
        echo '</form>';
    }
}
if(!empty($_POST['id_pr'])){
    $id = $_POST['id_pr'];
    $sql = "DELETE FROM produkty WHERE id_produktu=:id";
    $result = $pdo -> prepare($sql);
    $result -> bindValue(":id",$id);
    $result -> execute();
    echo "<p>Usunięto produkt. Proszę odświeżyć stronę </p>";
}
?>