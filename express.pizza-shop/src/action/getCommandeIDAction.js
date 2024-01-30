import { serviceCommande } from "../services/ServiceCommande.js";

/**
 * Action qui permet de récupérer une commande par son id
 */
export class getCommandeIDAction {

    commandeService = null;

    /**
     * Constructeur de la classe
     * initialise le service commande
     */
    constructor() {
        this.commandeService = new serviceCommande();
    }

    /**
     * Méthode qui permet de récupérer une commande par son id
     * @param id
     * @returns commande
     */
    async execute(id) {
        return  JSON.stringify(await this.commandeService.getCommande(id));
    }
}