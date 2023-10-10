<?php

namespace pizzashop\shop\domain\dto\commande;

class ItemDTO extends \pizzashop\shop\domain\dto\DTO
{
    public string $numero;
    public string $libelle;
    public int $taille;
    public int $quantite;
    public float $tarif;
    public string $libelle_taille;

    function __construct(string $numero, string $libelle, int $taille, int $quantite, float $tarif, string $libelle_taille)
    {
        $this->numero = $numero;
        $this->taille = $taille;
        $this->quantite = $quantite;
        $this->libelle = $libelle;
        $this->libelle_taille = $libelle_taille;
        $this->tarif = $tarif;
    }
}
