import amqp from 'amqplib';

export class serviceConsommation {

    rabbitmq = "";
    queue = "";
    exchange = "";
    routingKey = "";
    connect = null;
    channel = null;

    constructor(rabbitmq, queue, exchange, routingKey) {
        this.rabbitmq = rabbitmq;
        this.queue = queue;
        this.exchange = exchange;
        this.routingKey = routingKey;
    }

    async consume() {
        this.connect = await amqp.connect(this.rabbitmq);
        this.channel = await this.connect.createChannel();
        this.channel.consume(this.queue, (msg) => {
            console.log('msg content: ' + msg.content);
            let data = JSON.parse(msg.content)
            this.channel.ack(msg);
        })
    }

}
