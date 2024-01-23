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

async function getItem(id) {
    const item = await knex("item").where({ id }).first();

    return item;
}

async function getItems() {
    const items = await knex("item")
    .select({
        id : 'i.id',
        nom: 'i.nom',
        prix: 'i.prix'
    })
    .orderBy('i.nom', 'asc');

    return items;
}
