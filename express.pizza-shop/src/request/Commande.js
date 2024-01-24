import knex from "knex";

const bdd = knex({
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