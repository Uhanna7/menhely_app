<?php

class Felhasznalo {
    private string $felhasznalonev;
    private string $jelszo;
    private string $email;
    private int $szuletesiEv;
    private string $nem;
    private array $kosar;               // Ebben a tömbben fogjuk tárolni a felhasználó kosarában lévő pizzákat.

    // Konstruktor

    public function __construct(string $felhasznalonev, string $jelszo, string $email,
                                int $szuletesiEv=2000, string $nem="egyéb") {
        $this->felhasznalonev = $felhasznalonev;
        $this->jelszo = $jelszo;
        $this->email = $email;
        $this->szuletesiEv = $szuletesiEv;
        $this->nem = $nem;
        $this->kosar = [];
    }

    // Getterek és setterek

    public function getFelhasznalonev(): string {
        return $this->felhasznalonev;
    }

    public function setFelhasznalonev(string $felhasznalonev): void {
        $this->felhasznalonev = $felhasznalonev;
    }

    public function getJelszo(): string {
        return $this->jelszo;
    }

    public function setJelszo(string $jelszo): void {
        $this->jelszo = $jelszo;
    }

    public function getEmail(): string {
        return $this->email;
    }


    public function setEmail(string $email): void {
        $this->email = $email;
    }


    public function getSzuletesiEv(): int {
        return $this->szuletesiEv;
    }

    public function setSzuletesiEv(int $szuletesiEv): void {
        $this->szuletesiEv = $szuletesiEv;
    }

    public function getNem(): string {
        return $this->nem;
    }

    public function setNem(string $nem): void {
        $this->nem = $nem;
    }

    public function getKosar(): array {
        return $this->kosar;
    }

    public function setKosar(array $kosar): void {
        $this->kosar = $kosar;
    }

    // Az objektum szöveggé alakításáért felelő metódus

    public function __toString(): string {
        return $this->felhasznalonev . ", születési év: " . $this->szuletesiEv . ", e-mail cím: " .
            $this->email . ", neme: " . $this->nem;
    }

    // Egyéb metódusok

    public function kosarbaTesz(KosarItem $ujItem): void {
        foreach ($this->kosar as $item) {
            if ($item->getNev() === $ujItem->getNev()) {
                $item->setMennyiseg($item->getMennyiseg() + 1);
                $item->setAr($item->getAr() + $ujItem->getAr());
                return;
            }
        }

        $this->kosar[] = $ujItem;
    }
}