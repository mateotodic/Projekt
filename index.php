<?php include 'connect.php'; define('UPLPATH', 'img/'); ?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fer Gradnja d.o.o. - Izgradnja i projektovanje</title>
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

        <section class="hero">
            <h2>Gradimo s poverenjem već više od 20 godina</h2>
            <p>Stambeni, poslovni i industrijski objekti po sistemu „ključ u ruke" – od ideje do useljenja.</p>
            <a href="projekti.php" class="btn">Pogledajte naše projekte</a>
        </section>

        <!-- Stambeni projekti -->
        <section class="usluge">
            <h2>Stambeni objekti</h2>
            <div class="kartice">
            <?php
            $query = "SELECT * FROM projekti WHERE arhiva=0 AND kategorija='stambeni' LIMIT 3";
            $result = mysqli_query($dbc, $query);
            while ($row = mysqli_fetch_array($result)) {
                echo '<article class="kartica">';
                echo '<p class="projekt-meta">' . $row['kategorija'] . ' · ' . $row['datum'] . '</p>';
                echo '<h3><a href="clanak.php?id=' . $row['id'] . '">' . $row['naziv'] . '</a></h3>';
                echo '<p>' . $row['sazetak'] . '</p>';
                echo '</article>';
            }
            ?>
            </div>
        </section>

        <!-- Poslovni projekti -->
        <section class="usluge">
            <h2>Poslovni objekti</h2>
            <div class="kartice">
            <?php
            $query = "SELECT * FROM projekti WHERE arhiva=0 AND kategorija='poslovni' LIMIT 3";
            $result = mysqli_query($dbc, $query);
            while ($row = mysqli_fetch_array($result)) {
                echo '<article class="kartica">';
                echo '<p class="projekt-meta">' . $row['kategorija'] . ' · ' . $row['datum'] . '</p>';
                echo '<h3><a href="clanak.php?id=' . $row['id'] . '">' . $row['naziv'] . '</a></h3>';
                echo '<p>' . $row['sazetak'] . '</p>';
                echo '</article>';
            }
            ?>
            </div>
        </section>

    </main>

    <footer>
        <p>Autor: Ivan Horvat &nbsp;|&nbsp; <a href="mailto:ivan.horvat@fgradnja.rs">ivan.horvat@fgradnja.rs</a> &nbsp;|&nbsp; &copy; 2024 Fer Gradnja d.o.o.</p>
    </footer>

</body>
</html>
<?php mysqli_close($dbc); ?>
