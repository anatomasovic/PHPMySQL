// Aplikacija PORTAL

<?php
$email = $_POST['email'];
$pass = md5($_POST['pass']); // hesiranje passworda nakon dohvacanja
require_once('db.php'); 
$c=db(); //spajanje
$upit = "SELECT * FROM users WHERE email='$email' AND 
		 password = '$pass' LIMIT 1"; // gledamo postoji li taj logirani user u bazi
$r = $c->query($upit);
if($r && $r->num_rows==1) //ako je upit uspio i broj redaka je jedan (jer se username ne moze ponavljati) - mora biti tocno jedan
{
        $row = $r->fetch_assoc();
	session_start();
	$_SESSION['login']=$row['email']; //postavi mejl u varijablu login
	header("Location: profil.php"); //prebaci ga na njegov profiul na stranici
}
else 
{
	header("Location: login.htm"); //ako ga nismo nasli, vratimo ga na login obrazac
}
$c->close();
?>

###################################################################################################################################

//Sve stranice u zasticenom dijelu moraju imati: Session start i funkciju koja provjerava dali netko pokusava zaobici login i direktno 
//pristupiti zasticenom dijelu.

// FUNKCIJA ZA PROVJERU DA LI JE KORISNIK LOGIRAN NA STR
function logiran()
{
	if(!isset($_SESSION['login']))
	{  
		header("Location: login.htm"); //ako se nije ulogirao, znaci da pokusava pristupiti zasticenom dijelu; prebacimo ga na login
	}
}


- ove tri linije se nalaze u svakoj sticenoj stranici
---------------------
session_start();   
include 'db.php';  
logiran();         
---------------------

####################################################################################################################################

<?php

// Stranica za prikaz obrasca/registraciju novog korsnika portala

require 'db.php';

if(!$_POST)
{
    // Prikazi obrazac za registraciju
    // Baza: enum - radio button, vanjski kljuc - lista, T/F - checkbox
?>
    <form name="form1" method="post" action="">
    <p>Ime: 
        <input name="ime" type="text" id="email">
    </p>
    <p>Prezime: 
        <input name="prezime" type="text" id="pass">
    </p>
    <p>Email:
        <input name="email" type="text">
    <p>
    <p>Email ponovno:
        <input name="email2" type="text">
    <p>
    <p>Korisnicko ime:
        <input name="username" type="text">
    <p>  
    <p>Password:
        <input name="pass" type="password">
    <p>
    <input type="submit" name="submit" value="Register">
    </form>
<?php
}

else
{
    // Provjere + unos korisnika u bazu
    // Provjera 1 - ispunjenost svih polja obrasca
    $ime = $_POST['ime'];
    
    
    // Provjera 2 - podudaraju li se mejlovi
    // Provjera 3 - Email zauzet?
    // Provjera 4 - ako su provjere OK, upis korisnika u bazu (id_vrste = 1, po defaultu)
    
}

?>

#############################################################################################################################
