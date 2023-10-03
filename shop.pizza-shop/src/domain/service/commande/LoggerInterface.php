<?php
use \pizzashop\shop\domain\service\commande\ServiceCommande;

return [
    'commande.logger'=>function(\Psr\Container\ContainerInterface $c){
        $log=new \Monolog\Logger($c->get('log.commande.name'));
        $log->pushHandler(new \Monolog\Handler\StreamHandler($c->get('log.commande.file'),$c->get('log.commande.level')));
        return $log;
    },
    'product.service'=>function(\Psr\Container\ContainerInterface $c){
        return new \pizzashop\shop\domain\service\catalogue\ServiceCatalogue();
    },
    'commande.service'=>function(\Psr\Container\ContainerInterface $c){
        return new \pizzashop\shop\domain\service\commande\ServiceCommande($c->get('product.service'),$c->get('commande.logger'));
    }
];