<?php

namespace pizzashop\shop\domain\entities\catalogue;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use pizzashop\shop\domain\dto\catalogue\ProduitDTO;

class Produit extends \Illuminate\database\eloquent\Model
{

    protected $connection = 'catalog';
    protected $table = 'produit';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['numero', 'libelle', 'description','image'];

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function tailles(): BelongsToMany
    {
        return $this->belongsToMany(Taille::class, 'tarif', 'produit_id', 'taille_id')
            ->withPivot('tarif');
    }

    public function toDTO($tailles) : ProduitDTO {
        $taille = $this->tailles()->where('id', '=', $tailles)->first();
        $categ = $this->categorie()->first();
        return new ProduitDTO($this->numero, $this->libelle, $categ->libelle, $taille['libelle'], $taille->pivot->tarif);
    }

}