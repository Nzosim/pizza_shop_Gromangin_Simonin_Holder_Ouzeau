# PizzaShop

> Gromangin Clément,
> Simonin Enzo,
> Holder Jules

## Installation

- Clonez le projet
```
git clone https://github.com/ClemGrom/pizza_shop_Gromangin_Simonin_Holder_Ouzeau.git
```

- Installez les dépendances dans les dossiers : auth.pizza-shop, catalogue.pizza-shop, gateway.pizza-shop, shop.pizza-shop
```
composer install
```

- Lancez les containers docker depuis le dossier pizza.shop.components
```
docker-compose up -d
```

- Configurez votre environnement de developpement :
```
Dans le fichier pizza.shop.components/.env, commentez le ligne que vous n'utilisez pas
```

### Insérez les données dans les bases de données auth, catalogue et commande :

- Auth :
```
Lien : http://localhost:41222/?server=pizza-shop.auth.db&username=pizza_auth&db=pizza_auth
Mot de passe : pizza_auth
Les données sont dans le dossier auth.pizza-shop/sql, ajouté le fichier pizza_shop.auth.schema.sql
et ensuite le fichier pizza_shop.auth.data.sql
```

- Catalogue :
```
Lien : http://localhost:41222/?pgsql=pizza-shop.catalogue.db&username=pizza_catalog&db=pizza_catalog&ns=public
Mot de passe : pizza_catalog
Les données sont dans le dossier catalogue.pizza-shop/sql, ajouté le fichier pizza_shop.catalogue.schema.sql
et ensuite le fichier pizza_shop.catalogue.data.sql
```

- Commande :
```
Lien : http://localhost:41222/?server=pizza-shop.commande.db&username=pizza_shop&db=pizza_shop&select=commande
Mot de passe : pizza_shop
Les données sont dans le dossier commande.pizza-shop/sql, ajouté le fichier pizza_shop.commande.schema.sql
et ensuite le fichier pizza_shop.commande.data.sql
```

