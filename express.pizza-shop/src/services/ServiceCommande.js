import knex from "knex";
import { servicePublication } from "./ServicePublication.js";

export class serviceCommande {

    bdd = null;

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

    async getCommande(id) {
        let commande = await this.bdd("commande").where({id}).first();
        if (commande) {
            return commande;
        } else {
            throw new Error("Commande introuvable");
        }
    }

    async getCommandes() {
        return this.bdd("commande")
            .select()
            .orderBy('date_commande', 'asc');
    }

    async changeCommandeState(id) {
        let commande = await this.bdd("commande").where({id}).first();
        if (commande && commande.etape < 3) {
            commande.etape++;
            await this.bdd("commande").where({id}).update(commande);
            let updatedCommande = await this.bdd("commande").where({id}).first(); 

            let publi = new servicePublication('amqp://user:user@rabbitmq', 'suivi_commandes', 'pizzashop', 'suivi');
            publi.publish(JSON.stringify({id: updatedCommande.id, etape: updatedCommande.etape}));

            return updatedCommande;
        } else {
           throw new Error("Commande introuvable ou déjà terminée");
        }
    }

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