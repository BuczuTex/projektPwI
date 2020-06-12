<?php 
require("../../db.php");
session_start(); 
if(empty($_SESSION['admin'])) header("Location: ../../mainPage.php?Error=".urlencode("Access denied"));
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <title>Panel administracyjny</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="CSS/style.css">
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="controller.js"> </script>
<link rel="icon" href="obrazki/icon.png">
    </head>
    <body>
    <?php if(isset($_GET['Error'])){
            echo '<script> alert("'.$_GET['Error'].'")</script>';
        }?>
        <header>
            <h1>PANEL ADMINISTRACYJNY</h1>
        </header>
        <nav>
            <ul>
                <li><a href="panel-glowna.php">Lista produktów</a></li>
                <li><a href="panel-zamowienia.php">Lista zamówień</a> </li>
                <li><a href="../../mainPage.php">Powróć do sklepu</a></li>
            </ul>
        </nav>
        <div class="content">
            <div class="container">
                <?php
                $sql = "SELECT id_produktu,nazwa_produktu, zdjecie, alt FROM produkty";
                $result = $pdo->query($sql);
                while($row = $result->fetch()){
                  $row['zdjecie'] = '"../../'.$row["zdjecie"].'"';
                  echo '<div class="card produkt"> <div class="card-body"> ';
                  echo '<h5 class="card-title">'.$row['nazwa_produktu'].'</h5>';
                  echo '<img class="zdjecie_produktu" src='.$row['zdjecie'].' alt='.$row['alt'].'>';
                  echo '<img class="X" src="X.png" alt="Usuń produkt" title="Usuń produkt" width="45" height="45" onClick = "deleteProduct(this.id)" id="'.$row['id_produktu'].'">';
                  echo '<img class="modify" src="modify.png" alt="Zmodyfikuj produkt" title="Zmodyfikuj produkt" width="45" height="45" onClick = "getContent(this.id)" id="pr'.$row['id_produktu'].'">';
                  echo '<img class="zamow" src="zamow.png" alt="Dodaj do zamówienia" title="Dodaj do zamówienia" width="45" height="45" onClick="addToCartAdmin(this.id)" id="adm'.$row['id_produktu'].'">';
                  echo '</div></div>';
                }
                ?>
                <button type="button" class="btn btn-primary buttonik" data-toggle="modal" data-target="#add">Dodaj produkt</button>
                <form action="orderAdm.php">
                  <button type="submit" class="btn btn-primary buttonik">Sfinalizuj zamówienie</button>
                </form>
              </div>
              <div id="resultt">

              </div>
            </div>
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
                <div class="modal-body" id="usuwanie">
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
                <div class="modal-body" id="edycja">
                </div>
              </div>
            </div>
          </div>
          <!-- Modal z dodawaniem produktu -->
          <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="label2" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="label3">Dodaj produkt</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="addProduct.php" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="nazwa_produktu2">Nazwa produktu</label>
                      <input type="text" class="form-control" id="nazwa_produktu2" name="nazwa_produktu2" maxlength="100" required>
                      <label for="kategoria_produktu2">Kategoria produktu</label>
                      <input type="text" class="form-control" id="kategoria_produktu2" name="kategoria_produktu2" maxlength="30" required>
                      <label for="ilosc2">Ilość</label>
                      <input type="number" class="form-control" id="ilosc2" name="ilosc2" min="0" max="10000000000" required>
                      <label for="specyfikacja2">Specyfikacja produktu</label>
                      <textarea cols="50" rows="10" class="form-control" id="specyfikacja2" name="specyfikacja2" maxlength="65535" required></textarea>
                      <label for="opis2">Opis produktu</label>
                      <textarea cols="50" rows="10" class="form-control" id="opis2" name="opis2" maxlength="65535" required></textarea>
                      <label for="cena2">Cena produktu</label>
                      <input type="number" class="form-control" id="cena2" name="cena2" min="0" max="10000000000" required>
                      <label for="cena_promocyjna2">Cena promocyjna (zostawić puste, jeśli nie ma promocji)</label>
                      <input type="number" class="form-control" id="cena_promocyjna2" name="cena_promocyjna2" min="0" max="10000000000">
                      <label for="krotki_opis2">Krótki opis (delimiter /)</label>
                      <input type="text" class="form-control" id="krotki_opis2" name="krotki_opis2" maxlength="300" required>
                      <label for="alt2">Podpis alternatywny zdjęcia</label>
                      <input type="text" class="form-control" id="alt2" name="alt2" maxlength="30" required>
                      <label for="zdjecie">Zdjęcie produktu</label>
                      <input type="file" class="form-control" id="zdjecie" name="zdjecie" required>
                      <button type="submit" class="btn btn-primary" name="submit2">Dodaj produkt</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
    </body>
</html>