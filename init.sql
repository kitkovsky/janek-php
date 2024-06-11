DROP DATABASE IF EXISTS 333320_APLIKACJA;

CREATE DATABASE 333320_APLIKACJA;

USE 333320_APLIKACJA;

CREATE TABLE czytelnicy (
  id INT AUTO_INCREMENT PRIMARY KEY,
  mail VARCHAR(255) NOT NULL UNIQUE,
  numer_tel VARCHAR(255) NOT NULL UNIQUE,
  adres VARCHAR(255) NOT NULL,
  imie VARCHAR(255) NOT NULL,
  nazwisko VARCHAR(255) NOT NULL,
  bilans SMALLINT NOT NULL DEFAULT 0
);

CREATE TABLE autorzy (
  id INT AUTO_INCREMENT PRIMARY KEY,
  opis VARCHAR(1024) NOT NULL,
  imie VARCHAR(255) NOT NULL,
  nazwisko VARCHAR(255) NOT NULL
);

CREATE TABLE gatunki (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nazwa VARCHAR(255) NOT NULL UNIQUE,
  polecany_wiek SMALLINT NOT NULL
);

CREATE TABLE dziela (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nazwa VARCHAR(255) NOT NULL,
  ilosc_na_stanie INT NOT NULL,
  wydawnictwo VARCHAR(255) NOT NULL UNIQUE,
  autor_id INT UNIQUE,
  gatunek_id INT NOT NULL,
  FOREIGN KEY (autor_id) REFERENCES autorzy(id) ON DELETE SET NULL,
  FOREIGN KEY (gatunek_id) REFERENCES gatunki(id)
);

CREATE TABLE wypozyczenia (
  id INT AUTO_INCREMENT PRIMARY KEY,
  czytelnik_id INT NOT NULL UNIQUE,
  dzielo_id INT NOT NULL UNIQUE,
  data_wypozyczenia DATE NOT NULL,
  data_zwrotu DATE,
  FOREIGN KEY (czytelnik_id) REFERENCES czytelnicy(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (dzielo_id) REFERENCES dziela(id) ON UPDATE CASCADE
);

INSERT INTO czytelnicy (mail, numer_tel, adres, imie, nazwisko) VALUES
('anna.kowalska@example.com', '123456789', 'Glowna 31', 'Anna', 'Kowalska'),
('piotr.nowak@example.com', '234567890', 'Ladna 12', 'Piotr', 'Nowak'),
('maria.wisniewska@example.com', '345678901', 'Brzydka 1', 'Maria', 'Wisniewska'),
('jan.kowalczyk@example.com', '456789012', 'Gruba 9', 'Jan', 'Kowalczyk'),
('ewa.zielinska@example.com', '567890123', 'Zielona 6', 'Ewa', 'Zielinska');


INSERT INTO autorzy (opis, imie, nazwisko) VALUES
('Polski pisarz science fiction, znany z Solaris.', 'Stanislaw', 'Lem'),
('Amerykanski powiesciopisarz, nowelista i eseista.', 'Ernest', 'Hemingway'),
('Brytyjski autor i dziennikarz, znany z Folwarku zwierzecego i 1984.', 'George', 'Orwell'),
('Francuski powiesciopisarz i dramaturg, znany z Nedznikow.', 'Victor', 'Hugo'),
('Rosyjski autor, znany z Wojny i pokoju oraz Anny Kareniny.', 'Lew', 'Tolstoj');

INSERT INTO gatunki (nazwa, polecany_wiek) VALUES
('Science Fiction', 16),
('Fantastyka', 12),
('Thriller', 18),
('Romans', 14),
('Powiesc historyczna', 15),
('Powiesc', 8);

INSERT INTO dziela (nazwa, ilosc_na_stanie, wydawnictwo, autor_id, gatunek_id) VALUES
('Solaris', 25, 'Wydawnictwo XYZ', 1, 1),
('Stary czlowiek i morze', 30, 'Wydawnictwo ABC', 2, 6),
('Rok 1984', 20, 'Wydawnictwo LMN', 3, 3),
('Nedznicy', 35, 'Wydawnictwo OPQ', 4, 6),
('Wojna i pokoj', 40, 'Wydawnictwo RST', 5, 5);

INSERT INTO wypozyczenia (czytelnik_id, dzielo_id, data_wypozyczenia) VALUES
(1, 1, '2024-05-01'),
(2, 3, '2024-05-03'),
(3, 2, '2024-05-05'),
(4, 4, '2024-05-07'),
(5, 5, '2024-05-09');

UPDATE wypozyczenia
SET data_zwrotu = '2024-05-10'
WHERE id = 1;
