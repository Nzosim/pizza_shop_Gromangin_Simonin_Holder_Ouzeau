import knex from "knex";

const bdd = knex({
    client: "mysql",
    connection: {
        host: "pizza-shop.commande.db",
        port: 3306,
        user: "pizza_shop",
        password: "pizza_shop",
        database: "pizza_shop"
    }
});

