<?php 
session_start();
require('db.php'); 
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <title>Sklep Komputerowy</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="CSS/style2.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="icon" href="obrazki/icon.png">
    </head>
    <body>
    <?php if(isset($_GET['Error'])){
            echo '<script> alert("'.$_GET['Error'].'")</script>';
        }?>
        <header>
            <a href = "mainPage.php">
                <img src="obrazki/komputer.png" alt="banner" id="banner">
            </a>
        </header>
        <nav>
        <ul>
          <li class="donava"><a href="produkty.php">Produkty</a></li>
                <li class="donava"><a href="koszyk.php">Koszyk</a></li>
                <li class="donava"><a href="kontakt.html">Kontakt</a></li>
                <?php if(empty($_SESSION["id"]) and empty($_SESSION['admin'])): ?>
                <li class="donava"><a href="logowanie.php">Zaloguj się</a></li>
                <?php elseif(!empty($_SESSION['admin'])): ?>
                  <li class="donava"><a href="logout.php">Witaj <?=$_SESSION['admin']?></a></li>
                  <li class="donava"><a href="admin/pages/panel-glowna.php">Panel administracyjny</a></li>
                <?php else: ?>
                  <li class="donava"><a href="logout.php">Witaj <?=$_SESSION['id']?></a></li>
                <?php endif;?>
            </ul>
        </nav>
        <div class="content">
            <nav>
                <form action="#" method="POST">
                    <div class="form-row">
                      <div class="col-xs1">
                        <input type="text" class="form-control" name="search" placeholder="Szukaj przedmiotu">
                      </div>
                    </div>
                    <h3>Sortuj</h3>
                    <h3>Cena</h3>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sort" value=" ORDER BY cena DESC" id="max">
                      <label class="form-check-label" for="max">
                        Cena maksymalna
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sort" value=" ORDER BY cena ASC" id="min">
                      <label class="form-check-label" for="min">
                        Cena minimalna
                      </label>
                  </div>
                  <h3>Pokaż</h3>
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="category[]" value="Podzespoły komputerowe" id="podzespoly">
                      <label class="form-check-label" for="podzespoly">
                          Podzespoły komputerowe
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="category[]" value="Komputery" id="komputery">
                      <label class="form-check-label" for="komputery">
                          Komputery
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="category[]" value="Laptopy" id="laptopy">
                      <label class="form-check-label" for="laptopy">
                          Laptopy
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="category[]" value="Programy komputerowe" id="programy">
                      <label class="form-check-label" for="programy">
                          Programy komputerowe
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="category[]" value="Gry na konsole" id="gry_konsola">
                      <label class="form-check-label" for="gry_konsola">
                          Gry na konsole
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="category[]" value="Gry na PC" id="gry_PC">
                      <label class="form-check-label" for="gry_PC">
                          Gry na PC
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="category[]" value="Akcesoria komputerowe" id="akcesoria">
                      <label class="form-check-label" for="akcesoria">
                          Akcesoria komputerowe
                      </label>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Zastosuj">
                </form>
            </nav>
            <main>
            <?php
            $sql = 'SELECT id_produktu, nazwa_produktu, kategoria, zdjecie, krotki_opis, alt, cena, cena_promocyjna FROM produkty';
            $result;
            if(!empty($_POST['search'])) $sql .= ' WHERE nazwa_produktu LIKE '.'"%'.$_POST['search'].'%"'.' ';
                foreach($_POST as $category){
                  if(is_array($category)){
                    $count = count($category);
                    if(!empty($_POST['search'])) $sql .= ' AND kategoria IN(';
                    else $sql .= ' WHERE kategoria IN(';
                    foreach($category as $item){
                      if(--$count == 0) $sql .= "'".$item."'";
                      else $sql .= "'".$item."'".',';
                    }
                    $sql .= ')';
                  }
                }
            if(isset($_POST['sort'])) $sql .= $_POST['sort'];
            $result = $pdo->query($sql);
            while($row = $result->fetch()){
              echo '<div class="card w-100 produkt"> <a class="card-body" href=produkty/produkt.php?id='.$row['id_produktu'].'>';
              echo '<h5 class="card-title">'.$row['nazwa_produktu'].'</h5>';
              echo '<img class="zdjecie_produktu" src="'.$row['zdjecie'].'" alt='.$row['alt'].'>';
              foreach(explode('/',$row['krotki_opis']) as $description){
                echo '<p class="category">'.$description.'</p>';
              }
              if(empty($row['cena_promocyjna'])) echo '<h5 class="price">'.$row['cena'].' zł </h5></a></div>';
              else echo '<h5 class="price" style="color:red">'.$row['cena_promocyjna'].' zł </h5></a></div>';
            }
            ?>
            </main>
            <aside>
                <img src = "obrazki/scv.jpg" alt="ad" id="ad">
            </aside>
        </div>
        <footer>
            <h3>Sklep internetowy 2020 Nie ruszać strony!</h3>
          </footer>
    </body>
</html>