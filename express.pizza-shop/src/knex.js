import knex from "knex";

const knex = knex({
    client: "mysql",
    connection: {
        host: "pizza-shop.commande.db",
        port: 41219,
        user: "pizza_shop",
        password: "pizza_shop",
        database: "pizza_shop"
    }
});


