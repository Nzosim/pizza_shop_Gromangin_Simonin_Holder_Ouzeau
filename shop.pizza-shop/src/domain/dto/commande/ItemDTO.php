<?php

namespace pizzashop\shop\domain\dto\commande;

class ItemDTO extends \pizzashop\shop\domain\dto\DTO
{
    public string $numero;
    public string $libelle;
    public int $taille;
    public int $quantite;
    public float $tarif;

    function __construct(string $numero, string $libelle, int $taille, int $quantite, float $tarif)
    {
        $this->numero = $numero;
        $this->libelle = $libelle;
        $this->taille = $taille;
        $this->quantite = $quantite;
        $this->tarif = $tarif;
    }
}
