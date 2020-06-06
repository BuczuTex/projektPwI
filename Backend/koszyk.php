<?php
session_start();
$dsn = 'mysql:dbname=id12999600_sklep_komputerowy;host=hostname';
$user = 'id12999600_root';
try{
  $pdo = new PDO($dsn, $user);
} catch (PDOException $e){
  echo 'Nie udało się połączyć: '.$e->getMessage();
}
$sql = "SELECT nazwa_produktu,p.ilosc, pr.cena, p.id_produktu, zdjecie, alt FROM produkty p JOIN produkty_w_koszyku pr ON(p.id_produktu = pr.id_produktu)
        WHERE id_koszyka = (SELECT id_koszyka FROM koszyk ko JOIN klienci k ON(k.id_klienta=ko.id_klienta) 
        WHERE nazwa_uzytkownika = ?)";
$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <title>Sklep Komputerowy</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="CSS/style3.css">
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
            <a href = "mainPage.html">
                <img src="obrazki/komputer.png" alt="banner" id="banner">
            </a>
        </header>
        <nav>
            <ul>
            <li class="donava"><a href="produkty.php">Produkty</a></li>
                <li class="donava"><a href="koszyk.php">Koszyk</a></li>
                <li class="donava"><a href="kontakt.html">Kontakt</a></li>
                <?php if(empty($_SESSION["id"])): ?>
                <li class="donava"><a href="logowanie.php">Zaloguj się</a></li>
                <?php else: ?>
                  <li class="donava"><a href="logout.php">Witaj <?=$_SESSION['id']?></a></li>
                <?php endif;?>
            </ul>
          </nav>
          <div class="content">
            <main>
              <div class="koszyk">
                <?php
                $cenaK = 0;
                if(!empty($_SESSION['id'])){
                  //nazwa, zdjecie, cena
                  $opcjeDostawy = array(
                    "opcja1" => 0,
                    "opcja2" => 10,
                    "opcja3" => 17,
                    "opcja4" => 5
                  );
                  $result = $pdo -> prepare($sql);
                  $result -> bindValue(1, $_SESSION['id']);
                  $result -> execute();
                  while($row = $result -> fetch()){
                    echo '<div class="card produkt"><div class="card-body">';
                    echo '<h5 class="card-title nazwa_produktu">'.$row['nazwa_produktu'].'</h5>';
                    echo '<img class="zdjecie_produktu" src="'.$row['zdjecie'].'" alt='.$row['alt'].'></div>';
                    echo '<p class="card-price">'.$row['cena'].'zł</p></div>';
                    $cenaK +=$row['cena'];
                  }
                }
                else echo '<p style="color:white;">Aby dokonać zamówienia, należy się zalogować</p>';
                ?>
              </div>
            </main>
            <form action="#" method="POST">
            <div class="container">
            <?php if(!empty($_SESSION['id'])): ?>
                <div class="column2">
                    <div class="card wybor-dostawcy">
                        <div class="card-body">
                            <h5>Wybierz sposób dostawy</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="radioList" id="radio1" value="opcja1">
                                <label class="form-check-label" for="radio1">
                                  Odbiór osobisty
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="radioList" id="radio2" value="opcja2">
                                <label class="form-check-label" for="radio2">
                                  Poczta Polska
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="radioList" id="radio3" value="opcja3">
                                <label class="form-check-label" for="radio3">
                                  UPS
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="radioList" id="radio4" value="opcja4">
                                <label class="form-check-label" for="radio4">
                                  Paczkomat Inpost
                                </label>
                              </div> 
                                <button type="submit" class="btn btn-secondary">Zastosuj zmiany</button>
                              </div>
                    </div> <?php endif; ?>
                </div>
            </div>
            </form>
            <div class="column3">
            <?php if(!empty($_SESSION['id'])): ?>
                <div class="card zamow">
                    <div class="card-body">
                        <h4>Podsumowanie zamówienia</h4>
                        <?php
                        if(!empty($_POST['radioList'])){
                        echo '<h5>Wartość zakupów: '.$cenaK.'zł</h5>';
                        echo '<h5>Wartość dostawy: '.$opcjeDostawy[$_POST['radioList']].'zł</h5>';
                        $sumPrice = $cenaK+$opcjeDostawy[$_POST['radioList']];
                        echo '<h5>Łączna wartość zamówienia: '.$sumPrice.'zł</h5>';
                        $_SESSION['sumPrice'] = $sumPrice;
                        switch($_POST['radioList']){
                          case 'opcja1';
                            $_SESSION['dostawa'] = 'Odbiór osobisty';
                          break;
                          case 'opcja2';
                            $_SESSION['dostawa'] = 'Poczta Polska';
                          break;
                          case 'opcja3';
                            $_SESSION['dostawa'] = 'UPS';
                          break;
                          case 'opcja4';
                            $_SESSION['dostawa'] = 'Paczkomat Inpost';
                          break;
                        }
                        }
                        ?>
                        <form action="order.php" method="POST">
                          <button type="submit" class="btn btn-dark zamowienie">Zamów</button>
                        </form>
                        <form action="clear.php" method="POST">
                          <button type="submit" class="btn btn-danger zamowienie">Wyczyść koszyk</button>
                        </form>
                    </div>
              </div> <?php endif; ?>
                <div class="kontakt" style="padding:10px 20px 20px 20px;">
                    <h4>Skontaktuj się z nami<br>Telefon stacjonarny: 87 918 019<br>Telefon komórkowy: 512 091 728
                    <br><a href="mailto:example@example.com">Mail:example@example.com</a></h4>
                </div>
            </div>
        </div>
          <footer>
            <h3>Sklep internetowy 2020 Nie ruszać strony!</h3>
          </footer>
    </body>
</html>