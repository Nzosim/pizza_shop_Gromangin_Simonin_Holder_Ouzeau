import WebSocket, { WebSocketServer } from 'ws';

const server = new WebSocketServer({ port: 3000 , clientTracking: true});

const notifyAll = (msg) =>{
    server.clients.forEach((client_socket) => {
        if (client_socket.readyState === WebSocket.OPEN)
            client_socket.send(msg);
    });
}
server.on('connection', (client_socket) => {
    client_socket.on('error', console.error);
    client_socket.on('message', (message) => {
        console.log('received: %s', message);
        client_socket.send('Vous êtes abonné à cette commande : ' + message);
    });
    client_socket.on('close', (event) => {
        console.log('client disconnected ');
    });
});