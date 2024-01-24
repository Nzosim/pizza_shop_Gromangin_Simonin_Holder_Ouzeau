import express from "express";
import helmet from "helmet";
import {getCommande, getCommandes} from "request/Commande.js";

const app = express();
app.use(express.json());
app.use(express.urlencoded({extended: false}));
app.use(helmet());

app.get('/commandes', async (req, res, next) => {
    try {
        const user = await getCommandes();
        res.json(user);
    } catch (err) {
        console.log(err);
        next(err);
    }
})

app.get('/commande/:id', async (req, res, next) => {
    try {
        const user = await getCommande(req.params.id);
        res.json(user);
    } catch (err) {
        console.log(err);
        next(err);
    }
})
app.listen(port, () => {
    console.log(`listening on 3306`)
});