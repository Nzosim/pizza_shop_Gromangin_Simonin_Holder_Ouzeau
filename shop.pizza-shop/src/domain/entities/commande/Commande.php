<?php

namespace pizzashop\shop\domain\entities\commande;

use pizzashop\shop\domain\dto\commande\CommandeDTO;

class Commande extends \Illuminate\Database\Eloquent\Model
{
    const ETAT_CREE = 1;
    const ETAT_VALIDE = 2;
    const ETAT_PAYE = 3;
    const ETAT_LIVRE = 4;

    const LIVRAISON_SUR_PLACE = 1;
    const LIVRAISON_A_EMPORTER = 2;
    const LIVRAISON_A_DOMICILE = 3;

    protected $connection = 'commande';
    protected $table = 'commande';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;
    public $fillable = ['id', 'date_commande', 'type_livraison', 'etat', 'montant_total', 'id_client', 'delai'];

    public function items() : \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Item::class, 'commande_id');
    }

    public function calculerMontantTotal($id) {
//        echo "2) " . $id;
        $montant = 0;
//        echo $this;
        foreach ($this->items as $item) {
            $montant += $item->tarif * $item->quantite;
        }
        $this->montant_total = $montant;
        $this->save();
    }

    public function toDTO() : CommandeDTO {
        $commandeDTO = new CommandeDTO($this->mail_client, $this->type_livraison);
        $commandeDTO->id = $this->id;
        $commandeDTO->date_commande = ($this->date_commande);
        $commandeDTO->etat = $this->etat;
        $commandeDTO->montant = $this->montant_total;
        $commandeDTO->delai = $this->delai ?? 0;
        foreach($this->items as $item) {
            $commandeDTO->addItem($item->toDTO());
        }
        return $commandeDTO;
    }
}