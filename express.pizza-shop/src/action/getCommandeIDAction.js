import {json} from "express";

class getCommandeIDAction {
    commandeService = null;

    constructor(commandeService) {
        this.commandeService = commandeService;
    }

    async execute() {
        //TODO: faire passer l'id en param
        return json(this.commandeService.getCommande(id));
    }
}

export {getCommandeIDAction}
