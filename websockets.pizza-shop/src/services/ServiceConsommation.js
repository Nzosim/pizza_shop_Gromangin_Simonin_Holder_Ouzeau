import amqp from 'amqplib';

export class serviceConsommation {

    rabbitmq = "";
    queue = "";
    exchange = "";
    routingKey = "";
    connect = null;
    channel = null;
    socket = null;

    constructor(rabbitmq, queue, exchange, routingKey, socket) {
        this.rabbitmq = rabbitmq;
        this.queue = queue;
        this.exchange = exchange;
        this.routingKey = routingKey;
        this.socket = socket;
    }

    async consume() {
        this.connect = await amqp.connect(this.rabbitmq);
        this.channel = await this.connect.createChannel();
        this.channel.consume(this.queue, (msg) => {
            let message = msg.content.toString()
            message = JSON.parse(message);
            this.socket.sendChangeState(message);
            this.channel.ack(msg);
        })
    }

}