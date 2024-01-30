import knex from "knex";
import { servicePublication } from "./ServicePublication.js";

/**
 * Classe qui gère les commandes
 */
export class serviceCommande {

    bdd = null;

    /**
     * Constructeur de la classe
     * initialise la connexion à la base de données
     */
    constructor() {
        this.bdd = knex({
            client: "mysql",
            connection: {
                host: 'api.service.db',
                port: 3306,
                user: 'pizza_express',
                password: 'pizza_express',
                database: 'pizza_express'
            }
        });
    }

    /**
     * Méthode qui permet de récupérer une commande par son id
     * @param id
     * @returns commande
     */
    async getCommande(id) {
        let commande = await this.bdd("commande").where({id}).first();
        if (commande) {
            return commande;
        } else {
            throw new Error("Commande introuvable");
        }
    }

    /**
     * Méthode qui permet de récupérer toutes les commandes
     * @returns commandes
     */
    async getCommandes() {
        return this.bdd("commande")
            .select()
            .orderBy('date_commande', 'asc');
    }

    /**
     * Méthode qui permet de changer l'état d'une commande
     * @param id
     * @returns commande
     */
    async changeCommandeState(id) {
        let commande = await this.bdd("commande").where({id}).first();
        if (commande && commande.etape < 3) {
            commande.etape++;
            // ajout du nouvel état de la commande dans la base de données
            await this.bdd("commande").where({id}).update(commande);
            let updatedCommande = await this.bdd("commande").where({id}).first(); 

            // ajout de la commande dans la file rabbitmq
            let publi = new servicePublication('amqp://user:user@rabbitmq', 'suivi_commandes', 'pizzashop', 'suivi');
            publi.publish(JSON.stringify({id: updatedCommande.id, etape: updatedCommande.etape}));

            return updatedCommande;
        } else {
           throw new Error("Commande introuvable ou déjà terminée");
        }
    }

    /**
     * Méthode qui permet de créer une commande
     * @param commande
     * @returns commande
     */
    async createCommande(commande) {
        let newCommande = {};
        newCommande.delai = commande.delai;
        newCommande.id = commande.id;
        newCommande.date_commande = commande.date_commande;
        newCommande.type_livraison = commande.type_livraison;
        newCommande.etape = 1;
        newCommande.mail_client = commande.mail_client;
        let total = 0;
        commande.items.forEach(item => {
            total += item.tarif * item.quantite;
        });
        newCommande.montant_total = total;
        return await this.bdd("commande").insert(newCommande);
    }
}