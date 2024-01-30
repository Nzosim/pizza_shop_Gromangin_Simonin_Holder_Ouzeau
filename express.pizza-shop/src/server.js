import { serviceConsommation } from "./services/ServiceConsommation.js";
import { middleware } from "./router/middleware.js";

/**
 * méthode d'initialisation de l'application
 */
let init = async () => {
    // création du middleware qui défini les routes de l'application
    let middlewareApp = new middleware();

    // création du service de consommation de message rabbitmq
    let conso = new serviceConsommation('amqp://user:user@rabbitmq', 'nouvelles_commandes', 'pizzashop', 'nouvelle');
    conso.consume();
}

init();