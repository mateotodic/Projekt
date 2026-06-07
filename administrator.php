<?php
session_start();
include 'connect.php';
define('UPLPATH', 'img/');

$uspjesnaPrijava = false;
$admin = false;
$imeKorisnika = '';

// Provjera login forme
if (isset($_POST['prijava'])) {
    $prijavaIme     = $_POST['username'];
    $prijavaLozinka = $_POST['lozinka'];

    $sql  = "SELECT korisnicko_ime, lozinka, razina FROM korisnik WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $prijavaIme);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
    }
    mysqli_stmt_bind_result($stmt, $imeKorisnika, $lozinkaKorisnika, $levelKorisnika);
    mysqli_stmt_fetch($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0 && password_verify($prijavaLozinka, $lozinkaKorisnika)) {
        $uspjesnaPrijava = true;
        $admin = ($levelKorisnika == 1);
        $_SESSION['username'] = $imeKorisnika;
        $_SESSION['level']    = $levelKorisnika;
    } else {
        $uspjesnaPrijava = false;
    }
}

// Brisanje
if (isset($_POST['delete'])) {
    $id    = $_POST['id'];
    $sql   = "DELETE FROM projekti WHERE id = ?";
    $stmt  = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
    }
}

// Izmjena
if (isset($_POST['update'])) {
    $id         = $_POST['id'];
    $naziv      = $_POST['naziv'];
    $sazetak    = $_POST['sazetak'];
    $opis       = $_POST['opis'];
    $kategorija = $_POST['kategorija'];
    $arhiva     = isset($_POST['prikaz']) ? 0 : 1;

    $slika = $_FILES['slika']['name'];
    if (!empty($slika)) {
        move_uploaded_file($_FILES['slika']['tmp_name'], 'img/' . $slika);
        $sql = "UPDATE projekti SET naziv=?, sazetak=?, opis=?, slika=?, kategorija=?, arhiva=? WHERE id=?";
        $stmt = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 'sssssii', $naziv, $sazetak, $opis, $slika, $kategorija, $arhiva, $id);
            mysqli_stmt_execute($stmt);
        }
    } else {
        $sql = "UPDATE projekti SET naziv=?, sazetak=?, opis=?, kategorija=?, arhiva=? WHERE id=?";
        $stmt = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ssssii', $naziv, $sazetak, $opis, $kategorija, $arhiva, $id);
            mysqli_stmt_execute($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracija – Fer Gradnja d.o.o.</title>
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
            <h2>Administracija</h2>
            <p>Upravljanje projektima</p>
        </section>

        <section>
        <?php
        // --- ADMIN PRIJAVLJEN ---
        if (($uspjesnaPrijava && $admin) || (isset($_SESSION['username']) && $_SESSION['level'] == 1)):
            $result = mysqli_query($dbc, "SELECT * FROM projekti");
            while ($row = mysqli_fetch_array($result)):
        ?>
            <div class="forma-unos" style="margin-bottom:2rem;">
                <form action="administrator.php" method="POST" enctype="multipart/form-data">

                    <div class="form-item">
                        <label>Naziv projekta</label>
                        <input type="text" name="naziv" class="form-field-textual" value="<?php echo $row['naziv']; ?>">
                    </div>

                    <div class="form-item">
                        <label>Kratki sažetak</label>
                        <textarea name="sazetak" cols="30" rows="3" class="form-field-textual"><?php echo $row['sazetak']; ?></textarea>
                    </div>

                    <div class="form-item">
                        <label>Opis projekta</label>
                        <textarea name="opis" cols="30" rows="5" class="form-field-textual"><?php echo $row['opis']; ?></textarea>
                    </div>

                    <div class="form-item">
                        <label>Slika:</label>
                        <input type="file" name="slika">
                        <?php if (!empty($row['slika'])): ?>
                            <img src="<?php echo UPLPATH . $row['slika']; ?>" width="80px">
                        <?php endif; ?>
                    </div>

                    <div class="form-item">
                        <label>Kategorija</label>
                        <select name="kategorija" class="form-field-textual">
                            <option value="stambeni"      <?php if($row['kategorija']=='stambeni')      echo 'selected'; ?>>Stambeni objekat</option>
                            <option value="poslovni"      <?php if($row['kategorija']=='poslovni')      echo 'selected'; ?>>Poslovni objekat</option>
                            <option value="javni"         <?php if($row['kategorija']=='javni')         echo 'selected'; ?>>Javni objekat</option>
                            <option value="industrijski"  <?php if($row['kategorija']=='industrijski')  echo 'selected'; ?>>Industrijski objekat</option>
                            <option value="rekonstrukcija"<?php if($row['kategorija']=='rekonstrukcija')echo 'selected'; ?>>Rekonstrukcija</option>
                        </select>
                    </div>

                    <div class="form-item">
                        <label>Prikazati na stranici:
                            <input type="checkbox" name="prikaz" <?php if($row['arhiva']==0) echo 'checked'; ?>>
                        </label>
                    </div>

                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                    <div class="form-item">
                        <button type="submit" name="update">Izmjeni</button>
                        <button type="submit" name="delete">Izbriši</button>
                    </div>

                </form>
            </div>
        <?php
            endwhile;
            mysqli_close($dbc);

        // --- PRIJAVLJEN ALI NIJE ADMIN ---
        elseif (($uspjesnaPrijava && !$admin) || (isset($_SESSION['username']) && $_SESSION['level'] == 0)):
            echo '<p>Bok ' . (isset($_SESSION['username']) ? $_SESSION['username'] : $imeKorisnika) . '! Uspješno ste prijavljeni, ali nemate pravo pristupa administratorskoj stranici.</p>';

        // --- NEUSPJEŠNA PRIJAVA ---
        elseif ($uspjesnaPrijava === false && isset($_POST['prijava'])):
            echo '<p>Pogrešno korisničko ime ili lozinka. <a href="registracija.php">Registrirajte se</a>.</p>';
        ?>
            <div class="forma-unos">
                <form action="administrator.php" method="POST">
                    <div class="form-item">
                        <label for="username">Korisničko ime</label>
                        <input type="text" id="username" name="username" class="form-field-textual">
                    </div>
                    <div class="form-item">
                        <label for="lozinka">Lozinka</label>
                        <input type="password" id="lozinka" name="lozinka" class="form-field-textual">
                    </div>
                    <div class="form-item">
                        <button type="submit" name="prijava">Prijava</button>
                    </div>
                </form>
            </div>

        <?php
        // --- LOGIN FORMA (prvi dolazak) ---
        else:
        ?>
            <div class="forma-unos">
                <form action="administrator.php" method="POST">
                    <div class="form-item">
                        <label for="username">Korisničko ime</label>
                        <input type="text" id="username" name="username" class="form-field-textual">
                    </div>
                    <div class="form-item">
                        <label for="lozinka">Lozinka</label>
                        <input type="password" id="lozinka" name="lozinka" class="form-field-textual">
                    </div>
                    <div class="form-item">
                        <button type="submit" name="prijava">Prijava</button>
                    </div>
                </form>
                <p style="margin-top:1rem;">Nemate račun? <a href="registracija.php">Registrirajte se</a>.</p>
            </div>
        <?php endif; ?>

        </section>

    </main>

    <footer>
        <p>Autor: Ivan Horvat &nbsp;|&nbsp; <a href="mailto:ivan.horvat@fgradnja.rs">ivan.horvat@fgradnja.rs</a> &nbsp;|&nbsp; &copy; 2024 Fer Gradnja d.o.o.</p>
    </footer>

</body>
</html>
