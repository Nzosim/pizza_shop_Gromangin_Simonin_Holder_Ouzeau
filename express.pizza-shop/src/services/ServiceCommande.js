import knex from "knex";

const bdd = knex({
    client: "mariadb",
    connection: {
        host: 'pizza-shop.commande.db',
        port: 3306,
        user: 'pizza_shop',
        password: 'pizza_shop',
        database: 'pizza_shop'
    }
});

async function getCommande(id) {
    return knex("commande").where({id}).first();
}

async function getCommandes() {
    return knex("commande")
        .select({
            id: 'c.id',
            date: 'c.date_commande'
        })
        .orderBy('c.date_commande', 'desc');
}


export { getCommande, getCommandes }