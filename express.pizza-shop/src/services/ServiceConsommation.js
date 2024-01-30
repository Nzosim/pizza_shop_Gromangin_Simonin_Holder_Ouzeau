import amqp from 'amqplib';
import { serviceCommande } from "./ServiceCommande.js";

/**
 * Classe qui gère les messages de rabbitmq
 */
export class serviceConsommation {

    rabbitmq = "";
    queue = "";
    exchange = "";
    routingKey = "";
    connect = null;
    channel = null;
    commandeService = null;

    constructor(rabbitmq, queue, exchange, routingKey) {
        this.commandeService = new serviceCommande();
        this.rabbitmq = rabbitmq;
        this.queue = queue;
        this.exchange = exchange;
        this.routingKey = routingKey;
    }

    /**
     * Méthode qui permet de consommer les messages rabbitmq
     * reste en écoute sur la queue en permanence
     */
    async consume() {
        this.connect = await amqp.connect(this.rabbitmq);
        this.channel = await this.connect.createChannel();
        this.channel.consume(this.queue, (msg) => {
            this.commandeService.createCommande(JSON.parse(msg.content));
            this.channel.ack(msg);
        })
    }

}
