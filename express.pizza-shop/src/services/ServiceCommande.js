import knex from "knex";

export class serviceCommande {

    bdd = null;

    constructor() {
        this.bdd = knex({
            client: "mysql",
            connection: {
                host: 'pizza-shop.commande.db',
                port: 3306,
                user: 'pizza_shop',
                password: 'pizza_shop',
                database: 'pizza_shop'
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
        if (commande && commande.etat < 3) {
            commande.etat++;
            await this.bdd("commande").where({id}).update(commande);
            let updatedCommande = await this.bdd("commande").where({id}).first();
            return updatedCommande;
        } else {
           throw new Error("Commande introuvable ou déjà terminée");
        }
    }
}