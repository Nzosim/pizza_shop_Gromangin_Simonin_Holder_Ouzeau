<?php

namespace pizzashop\shop\domain\dto\commande;

class CommandeDTO extends \pizzashop\shop\domain\dto\DTO
{
    public string $id_client;

    public string $date;
    public int $type_livraison;
    public string $mail_client;
    public float $montant;
    public int $delai;
    public array $items;

    function __construct(string $id_client, string $date, int $type_livraison, string $mail_client, float $montant, int $delai, array $produits)
    {
        $this->id_client = $id_client;
        $this->date = $date;
        $this->type_livraison = $type_livraison;
        $this->mail_client = $mail_client;
        $this->montant = $montant;
        $this->delai = $delai;
        $this->produits = $produits;
    }


}