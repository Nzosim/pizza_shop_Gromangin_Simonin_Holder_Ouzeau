import { serviceCommande } from "../services/ServiceCommande.js";

/**
 * Action qui permet de changer l'état d'une commande

 */
export class changeCommandeState {

    commandeService = null;

    /**
     * Constructeur de la classe
     * initialise le service commande
     */
    constructor() {
        this.commandeService = new serviceCommande();
    }

    /**
     * Méthode qui permet de changer l'état d'une commande
     * @param id
     * @returns commande
     */
    async execute(id) {
        return  JSON.stringify(await this.commandeService.changeCommandeState(id));
    }
}