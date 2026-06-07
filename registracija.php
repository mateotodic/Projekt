<?php
session_start();
include 'connect.php';

$registriranKorisnik = false;
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ime      = $_POST['ime'];
    $prezime  = $_POST['prezime'];
    $username = $_POST['username'];
    $lozinka  = $_POST['pass'];
    $lozinka2 = $_POST['passRep'];
    $razina   = 0;

    if ($lozinka !== $lozinka2) {
        $msg = 'Lozinke se ne podudaraju!';
    } else {
        $hashed_password = password_hash($lozinka, CRYPT_BLOWFISH);

        // Provjera postoji li korisničko ime
        $sql  = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
        $stmt = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
        }

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $msg = 'Korisničko ime već postoji!';
        } else {
            // Unos korisnika u bazu
            $sql  = "INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($dbc);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, 'ssssi', $ime, $prezime, $username, $hashed_password, $razina);
                mysqli_stmt_execute($stmt);
                $registriranKorisnik = true;
            }
        }
    }
    mysqli_close($dbc);
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija – Fer Gradnja d.o.o.</title>
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
            <h2>Registracija</h2>
            <p>Kreirajte korisnički račun</p>
        </section>

        <section>
            <?php if ($registriranKorisnik == true): ?>
                <p>Korisnik je uspješno registriran! <a href="administrator.php">Prijavite se</a>.</p>
            <?php else: ?>
            <div class="forma-unos">
                <form action="registracija.php" method="POST">

                    <div class="form-item">
                        <label for="ime">Ime</label>
                        <input type="text" id="ime" name="ime" class="form-field-textual">
                    </div>

                    <div class="form-item">
                        <label for="prezime">Prezime</label>
                        <input type="text" id="prezime" name="prezime" class="form-field-textual">
                    </div>

                    <div class="form-item">
                        <label for="username">Korisničko ime</label>
                        <?php if (!empty($msg)) echo '<span style="color:var(--boja-primarna)">' . $msg . '</span>'; ?>
                        <input type="text" id="username" name="username" class="form-field-textual">
                    </div>

                    <div class="form-item">
                        <label for="pass">Lozinka</label>
                        <input type="password" id="pass" name="pass" class="form-field-textual">
                    </div>

                    <div class="form-item">
                        <label for="passRep">Ponovite lozinku</label>
                        <input type="password" id="passRep" name="passRep" class="form-field-textual">
                    </div>

                    <div class="form-item">
                        <button type="submit">Registriraj se</button>
                    </div>

                </form>
            </div>
            <?php endif; ?>
        </section>

    </main>

    <footer>
        <p>Autor: Ivan Horvat &nbsp;|&nbsp; <a href="mailto:ivan.horvat@fgradnja.rs">ivan.horvat@fgradnja.rs</a> &nbsp;|&nbsp; &copy; 2024 Fer Gradnja d.o.o.</p>
    </footer>

</body>
</html>
