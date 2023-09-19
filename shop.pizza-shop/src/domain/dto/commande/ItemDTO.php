<?php

namespace pizzashop\shop\domain\dto\commande;

class ItemDTO extends \pizzashop\shop\domain\dto\DTO
{
    public string $numero;
    public string $libelle;
    public int $taille;
    public int $quantite;
    public float $tarif;
    public int $commande_id;

    function __construct(string $numero, string $libelle, int $taille, int $quantite, float $tarif, $commande_id)
    {
        $this->numero = $numero;
        $this->libelle = $libelle;
        $this->taille = $taille;
        $this->quantite = $quantite;
        $this->tarif = $tarif;
        $this->commande_id = $commande_id;
    }
}
