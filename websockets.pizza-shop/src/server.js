import WebSocket, { WebSocketServer } from 'ws';
import amqp from 'amqplib';

const server = new WebSocketServer({ port: 3000 , clientTracking: true});

const notifyAll = (msg) =>{
    server.clients.forEach((client_socket) => {
        if (client_socket.readyState === WebSocket.OPEN)
            client_socket.send(msg);
    });
}

const clients = [];

server.on('connection', (client_socket) => {
    client_socket.on('error', console.error);
    client_socket.on('message', (message) => {
        console.log('received: %s', message);
        clients.push([client_socket, message]);
        client_socket.send('Vous êtes abonné à cette commande : ' + message);
    });
    client_socket.on('close', (event) => {
        clients.splice(clients.indexOf(client_socket), 1);
        console.log('client disconnected ');
    });
});




class serviceConsommation {

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
            let message = msg.content.toString()
            message = JSON.parse(message);
            let client = clients.find((client) => (client[1]).toString('utf8') === message.id);
            console.log("client : " + client);
            if (client) {
                client[0].send('Votre commande vient de passer à l\'étape : ' + message.etape );
            }
            this.channel.ack(msg);
        })
    }

}

let suivi = new serviceConsommation('amqp://user:user@rabbitmq', 'suivi_commandes', 'pizzashop', 'suivi');
suivi.consume();