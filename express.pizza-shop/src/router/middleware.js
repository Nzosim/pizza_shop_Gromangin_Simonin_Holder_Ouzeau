import express from "express";
import helmet from "helmet";
import { getCommandeIDAction } from "../action/getCommandeIDAction.js";
import { getCommandesAction } from "../action/getCommandesAction.js";
import { changeCommandeState } from "../action/changeCommandeState.js";

const app = express();
const port = process.env.PORT || 3000;
app.use(express.json());
app.use(express.urlencoded({extended: false}));
app.use(helmet());

app.get('/', (req, res) => res.send('Hello World!'));

app.get('/commandes', async (req, res, next) => {
    try {
        const actionCommandes = new getCommandesAction();
        res.send(await actionCommandes.execute());
    } catch (err) {
        console.log(err);
        next(err);
    }
})

app.get('/commandes/:id', async (req, res, next) => {
    try {
        const actionCommandeID = new getCommandeIDAction();
        res.send(await actionCommandeID.execute(req.params.id));
    } catch (err) {
        console.log(err);
        next(err);
    }
})

app.patch('/commandes/:id', async (req, res, next) => {
    try {
        const actionChangeCommandeState = new changeCommandeState();
        res.send(await actionChangeCommandeState.execute(req.params.id));
    } catch (err) {
        console.log(err);
        next(err);
    }
})

app.listen(port, () => {
    console.log(`App ready, listening on ${port}`)
});