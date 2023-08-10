CREATE TABLE Menhely(
    nev VARCHAR(255) PRIMARY KEY,
    kapacitas INT NOT NULL,
    varos VARCHAR(255),
    utca VARCHAR(255),
    hazszam INT
) ENGINE = InnoDB;


CREATE TABLE Orokbefogado(
    szigszam CHAR(8) PRIMARY KEY,
    nev VARCHAR(255) NOT NULL,
    nem CHAR(1),
    szul_datum DATE
) ENGINE = InnoDB;


CREATE TABLE Kutya(
    kod INT PRIMARY KEY AUTO_INCREMENT,
    nev VARCHAR(255) NOT NULL,
    nem CHAR(1),
    szul_ev INT,
    fajta VARCHAR(255),
    orokbefogado_szigszam CHAR(8) DEFAULT NULL,
    mikor DATE DEFAULT NULL,
    miota DATE NOT NULL,
    menhely_nev VARCHAR(255),
    FOREIGN KEY(orokbefogado_szigszam) 
		  REFERENCES Orokbefogado(szigszam),
    FOREIGN KEY(menhely_nev) 
		  REFERENCES Menhely(nev)
) ENGINE = InnoDB;


CREATE TABLE Dolgozo(
    szigszam CHAR(8) PRIMARY KEY,
    nev VARCHAR(255) NOT NULL,
    nem CHAR(1),
    szul_datum DATE,
    onkentes BOOLEAN DEFAULT true,
    menhely_nev VARCHAR(255) NOT NULL,
    FOREIGN KEY(menhely_nev) 
		REFERENCES Menhely(nev)
) ENGINE = InnoDB;


CREATE TABLE Eledel(
    keszlet_kod INT PRIMARY KEY AUTO_INCREMENT,
    marka VARCHAR(255) NOT NULL,
    tipus VARCHAR(255) NOT NULL,
    mennyiseg INT,
    menhely_nev VARCHAR(255) NOT NULL,
    FOREIGN KEY(menhely_nev) 
		  REFERENCES Menhely(nev)
) ENGINE = InnoDB;

CREATE TABLE Eszi(
    kutya_kod INT,
    eledel_keszlet_kod INT, 
    PRIMARY KEY(kutya_kod, eledel_keszlet_kod),
    FOREIGN KEY(kutya_kod) 
		  REFERENCES Kutya(kod),
    FOREIGN KEY(eledel_keszlet_kod) 
		  REFERENCES Eledel(keszlet_kod)    
) ENGINE = InnoDB;




INSERT INTO Menhely (nev, kapacitas, varos, utca, hazszam) VALUES ('Rex Kutyaotthon', 200, 'Sarkad', 'Kossuth Lajos', 12);
INSERT INTO Menhely (nev, kapacitas, varos, utca, hazszam) VALUES ('Tappancs Állatmenhely', 150, 'Békéscsaba', 'Petőfi Sándor', 23);

INSERT INTO Orokbefogado (szigszam, nev, nem, szul_datum) VALUES ('321999SE', 'Valaki Aki', 'f', '1998-02-15');
INSERT INTO Orokbefogado (szigszam, nev, nem, szul_datum) VALUES ('877231TE', 'Szabo Eva', 'n', '1971-07-24');

INSERT INTO Kutya (nev, nem, eletkor, fajta, miota, menhely_nev) VALUES ('Cipő', 'k', 4, 'keverek', '2020-03-12', 'Rex Kutyaotthon');
INSERT INTO Kutya (nev, nem, eletkor, fajta, orokbefogado_szigszam, mikor, miota, menhely_nev) VALUES ('Hami', 'k', 2, 'francia bulldog', '321999SE', '2021-08-02', '2021-02-02', 'Rex Kutyaotthon');

INSERT INTO Dolgozo (szigszam, nev, nem, szul_datum, onkentes, menhely_nev) VALUES ('77655KT', 'Nagy Nóra', 'n', '1982-10-22', false, 'Tappancs Állatmenhely');
INSERT INTO Dolgozo (szigszam, nev, nem, szul_datum, onkentes, menhely_nev) VALUES ('133411FG', 'Balázs Ábel', 'f', '1987-10-14', true, 'Tappancs Állatmenhely');

INSERT INTO Eledel (marka, tipus, mennyiseg, menhely_nev) VALUES ('Pedigree', 'junior', 12, 'Rex Kutyaotthon');
INSERT INTO Eledel (marka, tipus, mennyiseg, menhely_nev) VALUES ('Bellosan', 'normál', 20, 'Tappancs Állatmenhely');
INSERT INTO Eledel (marka, tipus, mennyiseg, menhely_nev) VALUES ('Happy Dog', 'allergén', 3, 'Rex Kutyaotthon');

INSERT INTO Eszi (kutya_kod, eledel_keszlet_kod) VALUES (1, 3);
INSERT INTO Eszi (kutya_kod, eledel_keszlet_kod) VALUES (2, 1);


INSERT INTO Orokbefogado (szigszam, nev, nem, szul_datum) VALUES ('321239SZ', 'Valaki Maki', 'f', '1997-02-15');
INSERT INTO Orokbefogado (szigszam, nev, nem, szul_datum) VALUES ('877243GE', 'Szabo Jozsi', 'f', '1982-04-24');

INSERT INTO Kutya (nev, nem, eletkor, fajta, orokbefogado_szigszam, mikor, miota, menhely_nev) VALUES ('Csutak', 'L', 4, 'mudi', '877243GE', '2021-02-04', '2020-03-12', 'Rex Kutyaotthon');
INSERT INTO Kutya (nev, nem, eletkor, fajta, orokbefogado_szigszam, mikor, miota, menhely_nev) VALUES ('Foltos', 'F', 5, 'keverek', '321239SZ', '2021-09-12', '2019-02-02', 'Rex Kutyaotthon');
INSERT INTO Kutya (nev, nem, eletkor, fajta, orokbefogado_szigszam, mikor, miota, menhely_nev) VALUES ('Dani', 'F', 6, 'keverek', '321239SZ', '2022-09-03', '2018-10-02', 'Rex Kutyaotthon');