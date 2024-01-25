import amqp from 'amqplib';

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

    async publish(message) {
        this.connect = await amqp.connect(this.rabbitmq);
        this.channel = await this.connect.createChannel();
        this.channel.publish(this.exchange, this.routingKey, Buffer.from(message));
    }

}