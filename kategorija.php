<?php
include 'connect.php';
define('UPLPATH', 'img/');

$kategorija = $_GET['kategorija'];
$sql  = "SELECT * FROM projekti WHERE arhiva=0 AND kategorija=?";
$stmt = mysqli_stmt_init($dbc);
if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, 's', $kategorija);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategorija: <?php echo $kategorija; ?> – Fer Gradnja d.o.o.</title>
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
            <h2>Kategorija: <?php echo ucfirst($kategorija); ?></h2>
            <p>Svi projekti iz ove kategorije</p>
        </section>

        <section class="projekti-grid">
        <?php
        while ($row = mysqli_fetch_array($result)) {
            echo '<article class="projekt-kartica">';
            echo '<p class="projekt-meta">' . $row['kategorija'] . ' · ' . $row['datum'] . '</p>';
            echo '<h3><a href="clanak.php?id=' . $row['id'] . '">' . $row['naziv'] . '</a></h3>';
            echo '<p>' . $row['sazetak'] . '</p>';
            echo '</article>';
        }
        mysqli_close($dbc);
        ?>
        </section>

    </main>

    <footer>
        <p>Autor: Ivan Horvat &nbsp;|&nbsp; <a href="mailto:ivan.horvat@fgradnja.rs">ivan.horvat@fgradnja.rs</a> &nbsp;|&nbsp; &copy; 2024 Fer Gradnja d.o.o.</p>
    </footer>

</body>
</html>
