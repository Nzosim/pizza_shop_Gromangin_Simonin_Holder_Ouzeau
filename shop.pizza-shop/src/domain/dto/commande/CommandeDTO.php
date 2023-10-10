<?php

namespace pizzashop\shop\domain\dto\commande;

class CommandeDTO extends \pizzashop\shop\domain\dto\DTO
{
    public string $id;
    public ?string $date_commande = null;
    public int $type_livraison;
    public int $etat = 1;
    public string $mail_client;
    public float $montant = 0;
    public int $delai = 0;
    public array $items = [];

    function __construct(string $mail_client, int $type_livraison)
    {
        $this->mail_client = $mail_client;
        $this->type_livraison = $type_livraison;
    }

    function addItem(ItemDTO $itemDTO)
    {
        $i = false;
        foreach ($this->items as $item) {
            if ($item->numero == $itemDTO->numero) {
                $item->quantite += 1;
                $i = true;
            }
        }
        if (!$i) $this->items[] = $itemDTO;
    }
}