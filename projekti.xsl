<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="/">
    <xsl:variable name="BrojProjekata" select="count(//Projekt)"/>

    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Projekti – Fer Gradnja d.o.o.</title>
        <link rel="stylesheet" type="text/css" href="style.css"/>
    </head>
    <body>

        <!-- ZAGLAVLJE -->
        <header>
            <div class="header-inner">
                <div class="logo">
                    <a href="index.php">
                        <img src="logo.png" alt="Fer Gradnja d.o.o." class="logo-slika"/>
                    </a>
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
                    </ul>
                </nav>
            </div>
        </header>

        <!-- TIJELO STRANICE -->
        <main>

            <section class="stranica-naslov">
                <h2>Pregled projekata (XML)</h2>
                <p>Prikazano <xsl:value-of select="$BrojProjekata"/> projekata iz XML kolekcije</p>
            </section>

            <section class="projekti-grid">
                <xsl:apply-templates select="//Projekt"/>
            </section>

        </main>

        <!-- PODNOŽJE -->
        <footer>
            <p>Autor: Ivan Horvat &#160;|&#160; <a href="mailto:ivan.horvat@fgradnja.rs">ivan.horvat@fgradnja.rs</a> &#160;|&#160; &#169; 2024 Fer Gradnja d.o.o.</p>
        </footer>

    </body>
    </html>

    </xsl:template>

    <!-- Template za svaki Projekt -->
    <xsl:template match="Projekt">
        <article class="projekt-kartica">
            <p class="projekt-meta">
                <xsl:value-of select="Kategorija"/> &#183; <xsl:value-of select="Datum"/>
            </p>
            <h3><xsl:value-of select="Naziv"/></h3>
            <p><xsl:value-of select="Sazetak"/></p>
        </article>
    </xsl:template>

</xsl:stylesheet>
