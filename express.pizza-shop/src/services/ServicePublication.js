import amqp from 'amqplib';

/**
 * Classe qui gère les publications de message rabbitmq
 */
export class servicePublication {

    rabbitmq = "";
    queue = "";
    exchange = "";
    routingKey = "";
    connect = null;
    channel = null;
    commandeService = null;

    constructor(rabbitmq, queue, exchange, routingKey) {
        this.rabbitmq = rabbitmq;
        this.queue = queue;
        this.exchange = exchange;
        this.routingKey = routingKey;
    }

    /**
     * Méthode qui permet de publier un message rabbitmq
     * @param message
     */
    async publish(message) {
        this.connect = await amqp.connect(this.rabbitmq);
        this.channel = await this.connect.createChannel();
        this.channel.publish(this.exchange, this.routingKey, Buffer.from(message));
    }

}