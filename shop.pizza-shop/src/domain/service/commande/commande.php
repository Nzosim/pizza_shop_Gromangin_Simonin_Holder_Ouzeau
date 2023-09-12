<?php

namespace pizzashop\shop\domain\service;

interface commande {

    CommandeDTO function lireCommande(string $UUID);
    CommandeDTO function validerCommande(string $UUID);

}