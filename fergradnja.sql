-- Kreiranje baze
CREATE DATABASE IF NOT EXISTS fergradnja CHARACTER SET utf8 COLLATE utf8_general_ci;
USE fergradnja;

-- Kreiranje tablice projekti
CREATE TABLE IF NOT EXISTS projekti (
    id          INT(11) NOT NULL AUTO_INCREMENT,
    datum       VARCHAR(32),
    naziv       VARCHAR(64) NOT NULL,
    sazetak     TEXT,
    opis        TEXT,
    slika       VARCHAR(64),
    kategorija  VARCHAR(64),
    arhiva      TINYINT(1) DEFAULT 0,
    PRIMARY KEY (id)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Kreiranje tablice korisnik
CREATE TABLE IF NOT EXISTS korisnik (
    id              INT(11) NOT NULL AUTO_INCREMENT,
    ime             VARCHAR(32),
    prezime         VARCHAR(32),
    korisnicko_ime  VARCHAR(32) UNIQUE,
    lozinka         VARCHAR(255),
    razina          TINYINT(1) DEFAULT 0,
    PRIMARY KEY (id)
) CHARACTER SET utf8 COLLATE utf8_general_ci;
