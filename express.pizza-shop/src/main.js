import { consommation } from "./rabbitmq/Consommation.js";

let conso = new consommation('amqp://user:user@rabbitmq', 'nouvelles_commandes', 'pizzashop', 'nouvelle');
conso.consume();