<?php

namespace pizzashop\shop\domain\service\commande;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\entities\commande\Commande;
use pizzashop\shop\domain\entities\commande\Item;
use pizzashop\shop\domain\service\catalogue\ServiceCatalogue;
use pizzashop\shop\domain\service\exception\ServiceCommandeInvalidItemException;
use pizzashop\shop\domain\service\exception\ServiceCommandeInvalidTransitionException;
use pizzashop\shop\domain\service\exception\ServiceCommandeInvialideException;
use pizzashop\shop\domain\service\exception\ServiceCommandeNotFoundException;
use pizzashop\shop\domain\service\exception\ServiceProduitNotFoundException;
use Psr\Log\LoggerInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Factory;
use Respect\Validation\Validator as v;

class ServiceCommande implements icommande
{

    private ServiceCatalogue $serviceInfoProduit;
    private LoggerInterface $logger;

    function __construct(ServiceCatalogue $serviceInfoProduit, LoggerInterface $logger)
    {
        $this->serviceInfoProduit = $serviceInfoProduit;
        $this->logger = $logger;
    }

    /**
     * @throws ServiceCommandeInvialideException
     */
    function validerDonneesDeCommande(CommandeDTO $commandeDTO): void
    {
        try {
            v::attribute('mail_client', v::email())
                ->attribute('type_livraison', v::intVal()->between(Commande::LIVRAISON_SUR_PLACE, Commande::LIVRAISON_A_DOMICILE))
                ->attribute('items', v::arrayVal()->notEmpty()
                    ->each(v::attribute('numero', v::intVal()->positive())
                        ->attribute('taille', v::in([1, 2]))
                        ->attribute('quantite', v::intVal()->positive())
                    ))
                ->assert($commandeDTO);
        } catch (NestedValidationException $e) {
//            echo $e->getFullMessage();
            throw new ServiceCommandeInvialideException($e);
        }
    }

    function accederCommande(string $UUID): CommandeDTO
    {
        try {
            $commande = Commande::where('id', '=', $UUID)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ServiceCommandeNotFoundException($UUID);
        }
        return $commande->toDTO();
    }

    function validationCommande(string $UUID): CommandeDTO
    {
        try {
            $commande = Commande::where('id', $UUID)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ServiceCommandeNotFoundException($UUID);
        }
        if ($commande->etat >= Commande::ETAT_VALIDE) {
            throw new ServiceCommandeInvalidTransitionException($UUID);
        }
        $commande->update(['etat' => Commande::ETAT_VALIDE]);
        $this->logger->info("Commande $UUID validée");
        return $commande->toDTO();
    }

    function creerCommande(CommandeDTO $commandeDTO): CommandeDTO
    {
        $commandeDTO->id = uniqid();
        $commandeDTO->date_commande = date('Y-m-d H:i:s');
        $commandeDTO->etat = Commande::ETAT_CREE;
        $commandeDTO->delai = 0;

//        $this->validerDonneesDeCommande($commandeDTO);

        //créer la commande
        $commande = Commande::create([
            'id' => $commandeDTO->id,
            'date_commande' => $commandeDTO->date_commande,
            'type_livraison' => $commandeDTO->type_livraison,
            'etat' => $commandeDTO->etat,
            'mail_client' => $commandeDTO->mail_client,
            'delai' => $commandeDTO->delai,
        ]);
        foreach ($commandeDTO->items as $itemDTO) {
            try {
                $infoItem = $this->serviceInfoProduit->getProduit($itemDTO['numero'], $itemDTO['taille']);
            } catch (ServiceProduitNotFoundException $e) {
                throw new ServiceCommandeInvalidItemException($itemDTO->numero, $itemDTO->taille);
            }
            $item = new Item();
            $item->numero = $itemDTO['numero'];
            $item->taille = $itemDTO['taille'];
            $item->quantite = $itemDTO['quantite'];
            $item->libelle_taille = $infoItem->libelle_taille;
            $item->tarif = $infoItem->tarif;
            $item->libelle = $infoItem->libelle_produit;
            $commande->items()->save($item);
        }
        $commande->calculerMontantTotal();
        $commande->save();

        $this->logger->info("Commande $commande->id créée");
        return $commande->toDTO();
    }

}

