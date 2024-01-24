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

async function getItem(id) {
    return knex("item").where({id}).first();
}

async function getItems() {
    return knex("item")
        .select({
            id: 'i.id',
            nom: 'i.nom',
            prix: 'i.prix'
        })
        .orderBy('i.nom', 'asc');
}

export {getItem, getItems}