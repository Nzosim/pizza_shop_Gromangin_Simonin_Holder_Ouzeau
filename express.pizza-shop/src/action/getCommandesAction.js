import { serviceCommande } from "../services/ServiceCommande.js";

/**
 * Action qui permet de récupérer toutes les commandes
 */
export class getCommandesAction {
    commandeService = null;

    /**
     * Constructeur de la classe
     * initialise le service commande
     */
    constructor() {
        this.commandeService = new serviceCommande();
    }

    /**
     * Méthode qui permet de récupérer toutes les commandes
     * @returns commandes
     */
    async execute() {
        return JSON.stringify(await this.commandeService.getCommandes());
    }
}
