import { serviceConsommation } from "./services/ServiceConsommation.js";
import { sockets } from "./websockets/sockets.js";

let websockets = new sockets();

let suivi = new serviceConsommation('amqp://user:user@rabbitmq', 'suivi_commandes', 'pizzashop', 'suivi', websockets);
suivi.consume();