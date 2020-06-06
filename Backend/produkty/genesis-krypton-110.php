<?php 
session_start();
$dsn = 'mysql:dbname=id12999600_sklep_komputerowy;host=hostname';
$user = 'id12999600_root';
try{
  $pdo = new PDO($dsn, $user);
} catch (PDOException $e){
  echo 'Nie udało się połączyć: '.$e->getMessage();
}
$sql = "SELECT * FROM produkty WHERE id_produktu = 2";
$result = $pdo->query($sql);
$row = $result->fetch();
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <title>Sklep Komputerowy</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="../CSS/produkt.css">
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
            <a href = "../mainPage.html">
                <img src="../obrazki/komputer.png" alt="banner" id="banner">
            </a>
        </header>
        <nav>
            <ul>
                <li class="donava"><a href="../produkty.php">Produkty</a></li>
                <li class="donava"><a href="../koszyk.php">Koszyk</a></li>
                <li class="donava"><a href="../kontakt.html">Kontakt</a></li>
                <?php if(empty($_SESSION["id"])): ?>
                <li class="donava"><a href="../logowanie.php">Zaloguj się</a></li>
                <?php else: ?>
                  <li class="donava"><a href="../logout.php">Witaj <?=$_SESSION['id']?></a></li>
                <?php endif;?>
            </ul>
          </nav>
          <div class="content">
            <div class="zdjecie">
              <div class="card">
                  <div class="card-body">
                  <img class="zd-prod" src=<?php echo '"../'.$row['zdjecie'].'"'; ?> height="277" width="300" alt=<?php echo '"'.$row['alt'].'"';?>>
                    </div>
                  </div>
              </div>
              <div class="description">
                  <div class="card">
                      <div class="body">
                          <h5><?php echo $row['nazwa_produktu']; ?></h5>
                          <?php 
                          $temp = explode('/',$row['krotki_opis']);
                          foreach($temp as $category){
                              echo '<h6>'.$category.'</h6>';
                          } 
                          if(!empty($row['cena_promocyjna'])) echo '<h6 style="color:red;">Cena: '.$row['cena_promocyjna'].'zł</h6>';
                          else echo '<h6>Cena: '.$row['cena'].'zł'.'</h6>';
                          ?>
                      </div>
                  </div>
              </div>
              <div class="zamow">
                  <div class="card">
                      <div class="card-body">
                          <h5>Szybka dostawa: Zamów teraz, by dostać jak najszybciej produkt</h5>
                          <h6>Dostępnych: <?php echo $row['ilosc'].' sztuk'; ?> </h6>
                          <form action="#" method="POST">
                                <div class="form-group">
                                <select name="ilosc" class="form-control" id="sel1">
                                <?php
                                for($i = 1; $i <= $row['ilosc']; $i++) echo '<option>'.$i.'</option>'; 
                                ?>
                                </select>
                                <button name="id" value="2" type="submit" class="btn btn-primary buttonik">Do koszyka</button>
                                </div>
                        </form>
                        <?php
                        if(isset($_POST['id'])) addToCart($pdo, $row);
                        function addToCart($pdo, $row){
                            if(empty($_SESSION['id'])) echo '<script> alert("Aby dodać do koszyka, należy się zalogować") </script>';
                            else{
                                $select = "SELECT ko.id_koszyka FROM koszyk ko JOIN klienci k ON (k.id_klienta = ko.id_klienta)
                                WHERE nazwa_uzytkownika = '".$_SESSION['id']."'";
                                $sql2 = "INSERT INTO produkty_w_koszyku(id_koszyka, id_produktu, ilosc, cena) VALUES(?, ?, ?, ?)";
                                $res = $pdo -> query($select);
                                $res2 = $res -> fetch(PDO::FETCH_ASSOC);
                                $ilosc = $_POST['ilosc'];
                                if(!empty($row['cena_promocyjna'])) $cenaK = $ilosc * $row['cena_promocyjna'];
                                else $cenaK = $ilosc * $row['cena'];
                                $koszyk = $pdo -> prepare($sql2);
                                $koszyk -> bindValue(1, $res2['id_koszyka']);
                                $koszyk -> bindValue(2, $_POST['id']);
                                $koszyk -> bindValue(3, $ilosc);
                                $koszyk -> bindValue(4, $cenaK);
                                $koszyk -> execute();
                            }
                        }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="opinie-opis">
            <div class="long-description">
                <div class="card">
                    <div class="card-body">
                        <h5>Specyfikacja</h5>
                        <p><?php echo $row['specyfikacja']; ?> </p>
                        <h5>Opis</h5>
                        <p><?php echo $row['opis']; ?> </p>
                    </div>
                </div>
            </div>
            <div class="opinie">
                <div class="card">
                    <div class="card-body">
                        <h5>Opinie użytkowników</h5>
                        <?php 
                        $sql = "SELECT k.nazwa_uzytkownika, data, tresc FROM opinie o  
                                JOIN klienci k ON (k.id_klienta = o.id_klienta)
                                WHERE id_produktu = 2";
                        $result = $pdo->query($sql);
                        while($row = $result->fetch()){
                            echo '<p>'.$row['nazwa_uzytkownika'].': '.$row['tresc'].'<br>'.$row['data'].'</p>';
                        }
                        ?>
                        <form action="addOpinion.php" method="POST">
                            <?php if(empty($_SESSION['id'])): echo '<p>Musisz być zalogowany, by dodawać opinie</p>'; ?>
                            <?php else: echo '<p>Podziel się swoją opinią na temat tego produktu!</p>
                            <textarea name="opinia" rows="10" cols="50" maxlength="500" required>Tekst nie może być dłuższy niż 500 znaków!</textarea>
                            <button type="submit" name="id" class="btn btn-primary" value="2">Prześlij</button>'; endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <h3>Sklep internetowy 2020 Nie ruszać strony!</h3>
        </footer>
    </body>
</html>