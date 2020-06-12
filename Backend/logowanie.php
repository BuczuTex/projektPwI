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
    <?php 
        if(isset($_GET['Error'])){
            echo '<script> alert("'.$_GET['Error'].'")</script>';
        }
    ?>
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
          <div class="content2">
            <div class="login"> 
                <div class="card card-login">
                   <div class="card-body">
                       <form action="login.php" method="POST">
                           <div class="form-group">
                               <label for="email">Adres e-mail</label>
                               <input type="email" class="form-control" name="email" id="email">
                           </div>
                           <div class="form-group">
                               <label for="hasloF">Podaj hasło</label>
                               <input type="password" class="form-control" name="password" id="hasloF">
                           </div>
                           <input type="submit" class="btn btn-primary" value="Zaloguj się">
                           <p style="margin-top: 10px;">Zapomniałeś hasła?</p> 
                       </form>
                    </div>
                </div>
             </div>
             <div class="rejestracja">
                 <div class="card card-register">
                     <div class="card-body">
                        <form action="register.php" method="POST">
                            <h5>Nie masz konta?</h5>
                            <div class="form-group">
                                <label for="email2">Adres e-mail</label>
                                <input type="email" class="form-control" id="email2" name="emailReg" required>
                            </div>
                            <div class="form-group">
                                <label for="user">Nazwa użytkownika</label>
                                <input type="text" class="form-control" id="user" name="userReg" required>
                            </div>
                            <div class="form-group">
                                <label for="haslo">Podaj hasło</label>
                                <input type="password" class="form-control" id="haslo" name="hasloReg" required>
                            </div>
                            <div class="form-group">
                                <label for="haslo2">Podaj ponownie hasło</label>
                                <input type="password" class="form-control" id="haslo2" name="haslo2Reg" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Zarejestruj się</button>
                     </div>
                 </div>
                 <div class="card card-register">
                     <div class ="form-group">
                         <label for="imie">Podaj imię</label>
                         <input type="text" class="form-control" id="imie" name="imieReg" required>
                     </div>
                     <div class ="form-group">
                         <label for="nazwisko">Podaj nazwisko</label>
                         <input type="text" class="form-control" id="nazwisko" name="nazwiskoReg" required>
                     </div>
                     <div class ="form-group">
                         <label for="miasto">Podaj miasto</label>
                         <input type="text" class="form-control" id="miasto" name="miastoReg" required>
                     </div>
                     <div class ="form-group">
                         <label for="adres">Podaj adres</label>
                         <input type="text" class="form-control" id="adres" name="adresReg" required>
                     </div>
                     <div class ="form-group">
                         <label for="kod-p">Podaj kod-pocztowy</label>
                         <input type="text" class="form-control" id="kod-p" name="kodReg" required>
                     </div>
                 </div>
                 </form>
             </div>
          </div>
          <footer>
            <h3>Sklep internetowy 2020 Nie ruszać strony!</h3>
          </footer>
    </body>
</html>