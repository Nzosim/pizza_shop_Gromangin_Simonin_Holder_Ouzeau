import knex from "knex";

export class serviceItem {

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

    async getItem(id) {
        return this.bdd("item").where({id}).first();
    }

    async getItems() {
        return this.bdd("item")
            .select()
            .orderBy('numero', 'asc');
    }
}