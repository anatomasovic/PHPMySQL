<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
<?php
//  SERVER, USERNAME, PASSWORD, BAZA
// postavljanje veze na bazu
$c = new mysqli("localhost", "root", "", "dwa2_anatomasovic"); //biramo klasu ovisno o serveru PostgreSQL...

// dohvacanje podataka - upit postaje argument metode query
// u objekt $r se sprema ono sto je dohvaceno
// dobijemo tablicu s dva stupca i 239 redaka
//$query = "SELECT Code, Name FROM Country ";
//$r->$c->query($query)

$r = $c->query("SELECT Code, Name FROM Country ");
	
// u svakom prolazu petlje dohvacamo jedan redak u varijablu $row
// tri nacina: asocijativno polje, numericko polje, object
while($row = $r->fetch_assoc()) 
{	
  // Code je asocijativni kljuc polja
	echo  $row['Code'] .' ---' . $row['Name'].'<br>';
}

// zatvaranje veze na bazu
$c->close();
?>


</body>
</html>

++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
<?php
// HTML obrazac za unos podataka
// kad je neko polje vanjski kljuc druge relacije - PADAJUCA LISTA: SELECT - jer vec postoji u bazi, samo treba odabrati
if (!$_POST)
{
    ?>
    <form name="obrazac" method="post" action="">
        <p>Zemlje: 
            <select name="kod">
                <?php
                $c = new mysqli("localhost", "root", "", "dwa2_anatomasovic");
                $r = $c->query("SELECT Code, Name FROM Country ");
                while($row = $r->fetch_assoc()) 
                {
                        echo '<option value="'.$row['Code'].'">'.$row['Name'].'</option>';
                }
                $c->close();
                ?>
            </select>
        <p>Jezik zemlje:
            <input name="naziv" type="text"></p>
        <p>Sluzbeni?:
            <input name="sluzbeni" type="radio" value="T">DA
            <input name="sluzbeni" type="radio" value="N">NE</p>
        <p>Postotak:
            <input name="postotak" type="number"></p>
        <input name="submission" type="submit" value="Posalji">
    </form>
    <?php
}

else
{
    // UNOS RETKA U TABLICU
    $kod = $_POST['kod'];
    $naziv = $_POST['naziv'];
    $sluzbeni = $_POST['sluzbeni'];
    $postotak = $_POST['postotak'];
    	    // provjera popunjenosti obrasca
    	    // 1. ako nisu popunjena sva polja, javi gresku i vrati se na obrazac
    	    
    	    // provjera ispravnosti podataka
    	    // 1. dohvati sve jezike u toj zemlji
    	    // 2. prodi kroz sve jezike i provjeri dali postoji barem jedan koji je sluzbeni (T)
    	    // prodi kroz sve jezike i provjeri sumu svih jezika, odnosno dali ce novi postotak preci preko 100
    	    
            // PRIPREMI UPIT
            $sql = "INSERT INTO CountryLanguage
                            (CountryCode,Language,IsOfficial,Percentage) 
                            VALUES 
                            ('$kod', '$naziv', '$sluzbeni', $postotak)";
            // OTVORI VEZU NA BAZU
            $c = new mysqli("localhost", "root", "", "dwa2_anatomasovic"); 
            // IZVRŠI UPIT
            $c->query($sql);
            if ($c->errno) // ako je postavljen kod greske, mozemo ispisati gresku
            {
                echo 'Greska: '.$c->error;
            }
            // provjera koliko je redaka upisano
            echo $c->affected_rows;
            // ZATVORI VEZU NA BAZU
            $c->close();
}
?>
</body>
</html>

++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
