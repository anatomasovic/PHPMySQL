// MIJENJAMO SHEMU BAZE TAKO DA UMJESTO DA IMAMO STUPAC LANGUAGE U TABLICI COUNTRYLANGUAGE
// IMATI CEMO ZASEBNU TABLICU LANGUAGE

<?php

// skripta za prebacivanje iz countrylanguages u languages

// 1. otvori vezu na bazu
$c = new mysqli("localhost", "root", "", "dwa2_anatomasovic");

if ($c->errno) // provjera je li spajanje na bazu uspjesno
            {
                echo 'Greska: '.$c->error;
                die(); //kada zelimo osigurati da ce izvrsavanje prestati nakon greske
            }

// 2 i 3. napisi upit koji dohvaca jedinstveni popis jezika i izvrsi u bazi
$r = $c->query("SELECT DISTINCT Language FROM countrylanguage ORDER BY Language");

if (!$r)
{
    echo "Nisam uspio dohvatiti sve jezike.";
    echo $c->error;
}


// 4. while petlja koja prolazi jezik po jezik
//      5. dinamicki kreiraj upit za upis u languages
//      6. izvrsi upit
while ($row = $r->fetch_assoc())
{
    $jezik = $row['Language'];
    $unosUpit = "INSERT INTO languages (naziv) VALUE ('$jezik');";
    //echo $unosUpit.'<br>'; --- provjera kako izgleda upis prije direktnog izvrsavanja u bazu
    $c->query($unosUpit);
}

// 7. zatvori vezu na bazu
$c->close();

?>

########################################################################################################

<?php

// dodali smo novu tablicu, pa zelimo da se u drugoj tablici naziv jezika zamijeni s njegovim id-em iz nove tablice languages

// otvori vezu na bazu
$c = new mysqli("localhost", "root", "", "dwa2_anatomasovic");

// napravi upit koji ce dohvatiti sve zapise iz CLanguages
$upit = "SELECT id, naziv FROM languages";

// izvrsi upit
$r = $c->query($upit);

// while petlja
//  pripremi upit (IZMJENI "lid" = languages.id)
// izvrsi upit
while ($row = $r->fetch_assoc())
{
    $lid = $row['id'];
    $naziv = $row['naziv'];
    $izmjeni = "UPDATE countrylanguage SET lid = $lid WHERE Language = '$naziv'";
    $c->query($izmjeni);
    //echo $izmjeni.'<br>'; --- provjera prije direktnog upisa u bazu
}

// zatvori vezu na bazu
$c->close();

?>

#######################################################################################################

// Treci korak: u PhpMyAdminu
 Moramo dropati Language, ali da ne ugrozimo tablicu.
 
 CountryCode, Language oznacimo, idemo na indexes, drop.
 Sada vise nema primarnog kljuca pa mozemo izbrisati Languages.
 Kliknemo drop pored Language.
 CountryCode i lid oznacimo i kliknemo na Primary.
 
 #####################################################################################################

ANKETE:

﻿<?php

function Fpregled($path) {


    // ČITANJE IZ TXT DATOTEKE
    $c = new mysql("localhost", "root", "", "dwa2_anatomasovic");
    $query = "SELECT * FROM ankete ORDER BY unesena DESC";
    $rAnkete = $c->query($query);
    echo '<table border="1" cellpadding="4">';
    while ($row = $r->fetch_assoc()) {
        echo '<tr>';
        // ANKETNO PITANJE
        echo '<td>' . $row['pitanje'] . '</td>';
        echo '<td>' . $row['objavljena'] . '</td>';
        echo '<td>' . $row['unesena'] . '</td>';
        // LINK ZA GLASANJE
        echo '<td>';
        echo ' <a href="?a=vote&id=' . $row['id'] . '"> GLASANJE </a><br>';
        echo '</td>';
        // LINK ZA IZMJENU
        echo '<td>';
        echo ' <a href="?a=editform&id=' . $row['id'] . '"> EDIT </a><br>';
        echo '</td>';
        // LINK ZA BRISANJE
        echo '<td>';
        echo ' <a href="?a=confirm&id=' . $row['id'] . '"> DELETE </a><br>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
    $c->close();
}
?>
