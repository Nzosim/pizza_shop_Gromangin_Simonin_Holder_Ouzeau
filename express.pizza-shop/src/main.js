import { serviceConsommation } from "./services/ServiceConsommation.js";

let conso = new serviceConsommation('amqp://user:user@rabbitmq', 'nouvelles_commandes', 'pizzashop', 'nouvelle');
conso.consume();