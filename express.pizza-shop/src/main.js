import { serviceConsommation } from "./services/ServiceConsommation.js";
import { middleware } from "./router/middleware.js";

let init = async () => {
    let middlewareApp = new middleware();

    let conso = new serviceConsommation('amqp://user:user@rabbitmq', 'nouvelles_commandes', 'pizzashop', 'nouvelle');
    conso.consume();
}

init();