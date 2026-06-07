<?php
include 'connect.php';
define('UPLPATH', 'img/');

$id   = $_GET['id'];
$sql  = "SELECT * FROM projekti WHERE id = ?";
$stmt = mysqli_stmt_init($dbc);
if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row    = mysqli_fetch_array($result);
}
mysqli_close($dbc);
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row['naziv']; ?> – Fer Gradnja d.o.o.</title>
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

        <section class="projekt-prikaz">

            <p class="category"><?php echo $row['kategorija']; ?></p>
            <h1 class="title"><?php echo $row['naziv']; ?></h1>
            <p class="meta">OBJAVLJENO: <?php echo $row['datum']; ?></p>

            <?php if (!empty($row['slika'])): ?>
            <section class="slika">
                <img src="<?php echo UPLPATH . $row['slika']; ?>" alt="<?php echo $row['naziv']; ?>">
            </section>
            <?php endif; ?>

            <section class="about">
                <p><?php echo $row['sazetak']; ?></p>
            </section>

            <section class="sadrzaj">
                <p><?php echo $row['opis']; ?></p>
            </section>

        </section>

    </main>

    <footer>
        <p>Autor: Ivan Horvat &nbsp;|&nbsp; <a href="mailto:ivan.horvat@fgradnja.rs">ivan.horvat@fgradnja.rs</a> &nbsp;|&nbsp; &copy; 2024 Fer Gradnja d.o.o.</p>
    </footer>

</body>
</html>
