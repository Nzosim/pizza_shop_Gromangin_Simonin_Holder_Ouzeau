import { serviceCommande } from "../services/ServiceCommande.js";

export class getCommandeIDAction {

    commandeService = null;

    constructor() {
        this.commandeService = new serviceCommande();
    }

    async execute(id) {
        return  JSON.stringify(await this.commandeService.getCommande(id));
    }
}