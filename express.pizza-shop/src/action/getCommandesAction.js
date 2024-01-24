import {json} from "express";

class getCommandesAction {
    commandeService = null;

    constructor(commandeService) {
        this.commandeService = commandeService;
    }

    async execute() {
        return json(this.commandeService.getCommandes());
    }
}

export {getCommandesAction}
