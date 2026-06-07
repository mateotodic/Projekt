<?php
if (isset($_POST['naziv'])) { $naziv = $_POST['naziv']; }
if (isset($_POST['sazetak'])) { $sazetak = $_POST['sazetak']; }
if (isset($_POST['opis'])) { $opis = $_POST['opis']; }
if (isset($_POST['kategorija'])) { $kategorija = $_POST['kategorija']; }
$prikaz = isset($_POST['prikaz']) ? 'Da' : 'Ne';
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregled projekta – Fer Gradnja d.o.o.</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

    <header>
        <div class="header-inner">
            <div class="logo">
                <a href="index.php">
                    <img src="logo.png" alt="Fer Gradnja d.o.o." class="logo-slika">
                </a>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Početna</a></li>
                    <li><a href="o-nama.html">O nama</a></li>
                    <li><a href="projekti.php">Projekti</a></li>
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
            <h2>Pregled unesenog projekta</h2>
            <p>Prikaz podataka poslatih iz obrasca</p>
        </section>

        <section class="projekt-prikaz">

            <p class="category"><?php echo $kategorija; ?></p>
            <h1 class="title"><?php echo $naziv; ?></h1>
            <p class="meta">AUTOR:</p>
            <p class="meta">OBJAVLJENO:</p>

            <section class="about">
                <p><?php echo $sazetak; ?></p>
            </section>

            <section class="sadrzaj">
                <p><?php echo $opis; ?></p>
            </section>

        </section>

    </main>

    <footer>
        <p>Autor: Ivan Horvat &nbsp;|&nbsp; <a href="mailto:ivan.horvat@fgradnja.rs">ivan.horvat@fgradnja.rs</a> &nbsp;|&nbsp; &copy; 2024 Fer Gradnja d.o.o.</p>
    </footer>

</body>
</html>
