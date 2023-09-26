<?php

namespace pizzashop\shop\domain\service\commande;

use Cassandra\Uuid;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PHPUnit\Exception;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\entities\commande\Commande;
use pizzashop\shop\domain\entities\commande\Item;
use pizzashop\shop\domain\service\catalogue\ServiceCatalogue;
use pizzashop\shop\domain\service\exception\ServiceCommandeInvalidItemException;
use pizzashop\shop\domain\service\exception\ServiceCommandeInvalidTransitionException;
use pizzashop\shop\domain\service\exception\ServiceCommandeNotFoundException;
use pizzashop\shop\domain\service\exception\ServiceProduitNotFoundException;

class ServiceCommande implements icommande
{

    private ServiceCatalogue $serviceInfoProduit;
//    private LoggerInterface $logger;

    function __construct(ServiceCatalogue $serviceInfoProduit) {
        $this->serviceInfoProduit = $serviceInfoProduit;
    }

    function validationCommande(CommandeDTO $commandeDTO): CommandeDTO
    {
        try {
            v::attribute('mail_client', v::email());
        } catch (ModelNotFoundException $e) {
            throw new ServiceCommandeNotFoundException("");
        }
        if ($commandeDTO->etat > Commande::ETAT_VALIDE) {
            throw new ServiceCommandeInvalidTransitionException("");

        }
        $commandeDTO->update(['etat' => Commande::ETAT_VALIDE]);
        $this->logger->info("Commande $UUID validée");
        return $commandeDTO->toDTO();
    }

    function accederCommande(string $UUID): CommandeDTO
    {
        try {
            $commande = Commande::findOrFail($UUID);
        } catch (Exception $e) {
            throw new ServiceCommandeNotFoundException($UUID);
        }
        return $commande->toDTO();
    }

    function validerCommande(string $UUID): CommandeDTO
    {
        try {
            $commande = Commande::where('id', $UUID)->firstOrFail();
        } catch (Exception $e) {
            throw new ServiceCommandeNotFoundException($UUID);
        }
        if ($commande->etat > Commande::ETAT_VALIDE) {
            throw new ServiceCommandeInvalidTransitionException($UUID);
        }
        $commande->update(['etat' => Commande::ETAT_VALIDE]);
//        $this->logger->info("Commande $UUID validée");
        return $commande->toDTO();
    }

    function creerCommande(CommandeDTO $commandeDTO): CommandeDTO
    {
        // valider les données de commande
//        $this->validerDonneesDeCommande($commandeDTO);

        //créer la commande
        $uuid = Uuid::uuid4();
        $commande = Commande::create([
            'id' => $uuid->toString(),
            'date_commande' => date('Y-m-d H:i:s'),
            'type_livraison' => $commandeDTO->type_livraison,
            'etat' => Commande::ETAT_CREE,
            'mail_client' => $commandeDTO->mail_client,
            'delai' => 0
        ]);
        foreach ($commandeDTO->items as $itemDTO) {
            try {
                $infoItem = $this->serviceInfoProduit->getProduit($itemDTO->numero, $itemDTO->taille, $itemDTO->quantite);
            } catch (ServiceProduitNotFoundException $e) {
                throw new ServiceCommandeInvalidItemException($itemDTO->numero, $itemDTO->taille);
            }
            $item = new Item();
            $item->numero = $itemDTO->numero;
            $item->taille = $itemDTO->taille;
            $item->quantite = $itemDTO->quantite;
            $item->libelle_taille = $infoItem->libelle_taille;
            $item->tarif = $infoItem->tarif;
            $item->libelle = $infoItem->libelle;
            $commande->items()->save($item);
        }
        $commande->calculerMontantTotal();
//        $this->logger->info("Commande $uuid créée");
        return $commande->toDTO();
    }

}

