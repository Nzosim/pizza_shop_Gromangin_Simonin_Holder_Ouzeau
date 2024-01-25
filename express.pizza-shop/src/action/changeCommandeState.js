import { serviceCommande } from "../services/ServiceCommande.js";

export class changeCommandeState {

    commandeService = null;

    constructor() {
        this.commandeService = new serviceCommande();
    }

    async execute(id) {
        return  JSON.stringify(await this.commandeService.changeCommandeState(id));
    }
}