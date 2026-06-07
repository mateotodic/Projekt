<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naziv      = $_POST['naziv'];
    $sazetak    = $_POST['sazetak'];
    $opis       = $_POST['opis'];
    $kategorija = $_POST['kategorija'];
    $datum      = date('d.m.Y.');
    $arhiva     = isset($_POST['prikaz']) ? 0 : 1;

    $slika = $_FILES['slika']['name'];
    if (!empty($slika)) {
        move_uploaded_file($_FILES['slika']['tmp_name'], 'img/' . $slika);
    }

    $sql  = "INSERT INTO projekti (datum, naziv, sazetak, opis, slika, kategorija, arhiva) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'ssssssi', $datum, $naziv, $sazetak, $opis, $slika, $kategorija, $arhiva);
        mysqli_stmt_execute($stmt);
    }
    mysqli_close($dbc);

    header('Location: projekti.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unos projekta – Fer Gradnja d.o.o.</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

    <header>
        <div class="header-inner">
            <div class="logo">
                <a href="index.php"><img src="logo.png" alt="Fer Gradnja d.o.o." class="logo-slika"></a>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Početna</a></li>
                    <li><a href="o-nama.html">O nama</a></li>
                    <li><a href="projekti.php">Projekti</a></li>
                    <li><a href="kategorija.php?kategorija=stambeni">Stambeni</a></li>
                    <li><a href="kategorija.php?kategorija=poslovni">Poslovni</a></li>
                    <li><a href="kontakt.html">Kontakt</a></li>
                    <li><a href="unos.php">Unos projekta</a></li>
                    <li><a href="administrator.php">Administracija</a></li>
                    <li><a href="projekti.xml">XML</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>

        <section class="stranica-naslov">
            <h2>Unos novog projekta</h2>
            <p>Popunite obrazac za dodavanje novog projekta u evidenciju</p>
        </section>

        <section>
            <div class="forma-unos">
                <form name="unos_projekta" action="unos.php" method="POST" enctype="multipart/form-data">

                    <div class="form-item">
                        <label for="naziv">Naziv projekta</label>
                        <input type="text" id="naziv" name="naziv" class="form-field-textual" autofocus>
                    </div>

                    <div class="form-item">
                        <label for="sazetak">Kratki sažetak projekta (do 50 znakova)</label>
                        <textarea name="sazetak" id="sazetak" cols="30" rows="3" class="form-field-textual"></textarea>
                    </div>

                    <div class="form-item">
                        <label for="opis">Opis projekta</label>
                        <textarea name="opis" id="opis" cols="30" rows="6" class="form-field-textual"></textarea>
                    </div>

                    <div class="form-item">
                        <label for="slika">Slika projekta:</label>
                        <input type="file" accept="image/jpg,image/gif,image/png" name="slika" id="slika">
                    </div>

                    <div class="form-item">
                        <label for="kategorija">Kategorija projekta</label>
                        <select name="kategorija" id="kategorija" class="form-field-textual">
                            <option value="stambeni">Stambeni objekat</option>
                            <option value="poslovni">Poslovni objekat</option>
                            <option value="javni">Javni objekat</option>
                            <option value="industrijski">Industrijski objekat</option>
                            <option value="rekonstrukcija">Rekonstrukcija</option>
                        </select>
                    </div>

                    <div class="form-item">
                        <label>Prikazati projekt na stranici:
                            <input type="checkbox" name="prikaz" value="da" checked>
                        </label>
                    </div>

                    <div class="form-item">
                        <button type="reset">Poništi</button>
                        <button type="submit">Prihvati</button>
                    </div>

                </form>
            </div>
        </section>

    </main>

    <footer>
        <p>Autor: Ivan Horvat &nbsp;|&nbsp; <a href="mailto:ivan.horvat@fgradnja.rs">ivan.horvat@fgradnja.rs</a> &nbsp;|&nbsp; &copy; 2024 Fer Gradnja d.o.o.</p>
    </footer>

</body>
</html>
