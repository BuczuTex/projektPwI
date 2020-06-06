<?php
$dsn = 'mysql:dbname=id12999600_sklep_komputerowy;host=hostname';
$user = 'id12999600_root';
try{
  $pdo = new PDO($dsn, $user);
} catch (PDOException $e){
  echo 'Nie udało się połączyć: '.$e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <title>Panel administracyjny</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="CSS/style.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="icon" href="obrazki/icon.png">
    </head>
    <body>
        <header>
            <h1>PANEL ADMINISTRACYJNY</h1>
        </header>
        <nav>
            <ul>
                <li><a href="panel-glowna.html">Lista produktów</a></li>
                <li><a href="panel-zamowienia.html">Lista zamówień</a> </li>
                <li><a href="../../mainPage.html">Wyloguj się i powróć do sklepu</a></li>
            </ul>
        </nav>
        <!--Modal z potwierdzeniem usunięcia-->
        <div class="modal fade" id="usun" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="label1">Usunąć produkt?</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <p>Czy chcesz na pewno usuąć ten produkt?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Nie</button>
                  <button type="button" class="btn btn-primary">Tak</button>
                </div>
              </div>
            </div>
          </div>
        <!--Modal z formularzem modyfikacji-->
        <div class="modal fade" id="modify" tabindex="-1" role="dialog" aria-labelledby="label2" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="label2">Modyfikuj produkt</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="specyfikacja1">Specyfikacja 1</label>
                            <input type="text" class="form-control" id="specyfikacja1">
                          </div>
                          <div class="form-group">
                            <label for="wartosc1">Zawartość specyfikacji 1</label>
                            <input type="text" class="form-control" id="wartosc1">
                          </div>
                          <div class="form-group">
                            <label for="specyfikacja2">Nazwa specyfikacji 2</label>
                            <input type="text" class="form-control" id="specyfikacja2">
                          </div>
                          <div class="form-group">
                            <label for="wartosc2">Zawartość specyfikacji 2</label>
                            <input type="text" class="form-control" id="wartosc2">
                          </div>
                          <div class="form-group">
                            <label for="specyfikacja3">Specyfikacja 3</label>
                            <input type="text" class="form-control" id="specyfikacja3">
                          </div>
                          <div class="form-group">
                            <label for="wartosc3">Zawartość specyfikacji 3</label>
                            <input type="text" class="form-control" id="wartosc3">
                          </div>
                          <div class="form-group">
                            <label for="specyfikacja4">Nazwa specyfikacji 4</label>
                            <input type="text" class="form-control" id="specyfikacja4">
                          </div>
                          <div class="form-group">
                            <label for="wartosc4">Zawartość specyfikacji 4</label>
                            <input type="text" class="form-control" id="wartosc4">
                          </div>
                          <div class="form-group">
                            <label for="opis-produktu">Opis produktu</label>
                            <textarea class="form-control" rows="10" id="opis-produktu"></textarea>
                          </div>
                    </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj zmiany</button>
                  <button type="button" class="btn btn-primary">Zatwierdź zmiany</button>
                </div>
              </div>
            </div>
          </div>
        <div class="content">
            <div class="container">
                <?php
                $sql = "SELECT nazwa_produktu, zdjecie, alt FROM produkty";
                $result = $pdo->query($sql);
                while($row = $result->fetch()){
                  $row['zdjecie'] = '"../../'.$row["zdjecie"].'"';
                  echo '<div class="card produkt"> <div class="card-body"> ';
                  echo '<h5 class="card-title">'.$row['nazwa_produktu'].'</h5>';
                  echo '<img class="zdjecie_produktu" src='.$row['zdjecie'].' alt='.$row['alt'].'>';
                  echo '<img class="X" src="X.png" alt="Usuń produkt" title="Usuń produkt" width="45" height="45" data-toggle="modal" data-target="#usun">';
                  echo '<img class="modify" src="modify.png" alt="Zmodyfikuj produkt" title="Zmodyfikuj produkt" width="45" height="45" data-toggle="modal" data-target="#modify">';
                  echo '</div></div>';
                }
                ?>
              </div>
            </div>
    </body>
</html>