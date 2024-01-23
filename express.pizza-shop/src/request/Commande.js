import knex from "knex";

const knex = knex({
    client: "mysql",
    connection: {
    host: 'localhost',
    port: 3306,
    user: 'dbuser',
    password: process.env.MARIADB_PASSWORD,
    database: 'dbdemo'
    }
    });

async function getCommande(id) {
    const commande = await knex("commande").where({ id }).first();

    return commande;
}

async function getCommandes() {
    const commandes = await knex("commande")
    .select({
        id : 'c.id',
        date: 'c.date_commande'
    })
    .orderBy('c.date_commande', 'desc');

    return commandes;
}


export { getCommande, getCommandes}