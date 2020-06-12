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
        <link rel="stylesheet" type="text/css" href="CSS/style.css">
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
          <main>
            <h2>NAJLEPSZE OKAZJE</h2>
            <div class="container">
                <?php
                $iterator = 0;
                $sql = "SELECT * FROM produkty WHERE cena_promocyjna IS NOT NULL AND cena_promocyjna <= cena * 0.5";
                $result = $pdo->query($sql);
                if($result->rowCount() == 0) echo "<h2>Zapraszamy do śledzenia strony, by być na bieżąco z promocjami</h2>";
                else{
                  echo '<div id="carouselExampleControls2" class="carousel slide" data-ride="carousel"> <div class="carousel-inner">';
                  while($row = $result -> fetch()){
                    if($iterator == 0) echo '<div class="carousel-item active"><div class="card-group">';
                    else if($iterator % 5 == 0) echo '<div class="carousel-item"><div class="card-group">';
                    echo '<a class="card" href="produkty/produkt.php?id='.$row['id_produktu'].'">';
                    echo '<img class="card-img-top" src="'.$row['zdjecie'] .'" alt='.$row['alt'].' width="150" height="150">
                          <div class="card-body">';
                    echo '<div class="card-text">'.$row['nazwa_produktu'].'</div>
                          <p class="card-price-deleted">'.$row['cena'].'zł</p>
                          <p class="card-new-price">'.$row['cena_promocyjna'].'zł</p></div></a>';
                    if($iterator % 5 == 4) echo '</div></div>';
                    ++$iterator;
                  }
                  if($iterator % 5 != 4) echo '</div></div>';
                  echo '<a class="carousel-control-prev" href="#carouselExampleControls2" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls2" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                        </a>';
                  echo '</div> </div></div></div>';
                }
                ?>
            </div>
            <h2>MNIEJ NIŻ 15 PRODUKTÓW DO KUPNA</h2>
            <div class="container">
            <?php
                $iterator = 0;
                $sql = "SELECT * FROM produkty WHERE ilosc < 15";
                $result = $pdo->query($sql);
                if($result->rowCount() == 0) echo "<h2>Zapraszamy do śledzenia strony, by być na bieżąco z promocjami</h2>";
                else{
                  echo '<div id="carouselExampleControls" class="carousel slide" data-ride="carousel"> <div class="carousel-inner">';
                  while($row = $result -> fetch()){
                    if($iterator == 0) echo '<div class="carousel-item active"><div class="card-group">';
                    else if($iterator % 5 == 0) echo '<div class="carousel-item"><div class="card-group">';
                    echo '<a class="card" href="produkty/produkt.php?id='.$row['id_produktu'].'">';
                    echo '<img class="card-img-top" src="'.$row['zdjecie'] .'" alt='.$row['alt'].' width="150" height="150">
                          <div class="card-body">';
                    echo '<div class="card-text">'.$row['nazwa_produktu'].'</div>
                          <p class="card-price-deleted">'.$row['cena'].'zł</p>
                          <p class="card-new-price">'.$row['cena_promocyjna'].'zł</p></div></a>';
                    if($iterator == 4) echo '</div></div>';
                    ++$iterator;
                  }
                  if($iterator % 5 != 4) echo '</div></div>';
                  echo '<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                        </a>';
                  echo '</div></div>';
                }
                ?>
            </div>
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