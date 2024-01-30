import WebSocket, { WebSocketServer } from 'ws';

export class sockets {

    server = null;
    clients = [];

    constructor() {
        this.server = new WebSocketServer({ port: 3000 , clientTracking: true});

        this.server.on('connection', (client_socket) => {
            client_socket.on('error', console.error);
            client_socket.on('message', (message) => {
                console.log('received: %s', message);
                this.clients.push([client_socket, message]);
                client_socket.send('Vous êtes abonné à cette commande : ' + message);
            });
            client_socket.on('close', (event) => {
                this.clients.splice(this.clients.indexOf(client_socket), 1);
                console.log('client disconnected ');
            });
        });
    }

    sendChangeState(message) {
        this.client = this.clients.find((client) => (client[1]).toString('utf8') === message.id);
        console.log("client : " + this.client);
        if (this.client) {
            let etape = message.etape === 2 ? 'en cours de préparation' : 'prête';
            this.client[0].send('Votre commande est ' + etape );
        }
    }

}