<?php

namespace pizzashop\shop\domain\entities\item;

class Item extends \Illuminate\Database\Eloquent\Model
{

    protected $numero = 'numero';
    protected $libelle = 'libelle';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $taille ='taille';
    protected $tarif ='tarif';
    protected $quantite ='quantite';
    protected $commande_id ='commande_id';

    public function commande()
    {
        return $this->hasMany(Commande::class, 'commande_id');
    }

}