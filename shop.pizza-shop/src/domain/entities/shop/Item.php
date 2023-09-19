<?php

namespace pizzashop\shop\domain\entities\shop;

class Item extends \Illuminate\Database\Eloquent\Model
{

    protected $connection = 'shop';
    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id', 'numero', 'libelle','taille', 'tarif', 'quantite', 'commande_id'];

    public function commande() : \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Commande::class, 'commande_id');
    }

}