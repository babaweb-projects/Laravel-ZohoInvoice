# Laravel ZohoInvoice

Implémentation de l'API **Zoho Invoice** pour **Laravel**

## Prérequis

Pour fonctionner, l'ensemble des élements sont nécessaires :
+ [Laravel 5.x](https://laravel.com/docs/master)
+ [ZohoInvoice API v3](https://www.zoho.com/invoice/api/v3/)

## Installation

Ajouter cette ligne à votre _composer.json_ dans le tableau "require" : 

    "require": {
        "php": ">=7.0.0",
        "laravel/framework": "5.5.*",
        "babaweb/zohoinvoice": "dev-master",
    },

Ajouter le tableau "repositories" :

    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/babaweb-projects/Laravel-ZohoInvoice"
        }
    ],

Mise à jour de _composer_ :

    composer update

Modifier le fichier `config/app.php` pour y ajouter le _provider_

    'providers' => [
        ...
        Babaweb\ZohoInvoice\ZohoInvoiceServiceProvider::class
    ],

Enfin publier le fichier :

    php artisan vendor:publish --provider="Babaweb\ZohoInvoice\ZohoInvoiceServiceProvider"

Et **tadaaa** ! Le package est prêt.

## Configuration
Afin de se connecter à l'API ZohoInvoice, des _tokens_ sont nécessaires. 
Pour les renseigner, il faut ouvrir le fichier dans `config/zohoinvoice.php` :

    return [
        'authtoken' => env('ZOHO_AUTHTOKEN', 'VOTRE_AUTH_TOKEN'),
        'organization_id' => env('ZOHO_ORGANIZATION', 'VOTRE_ORGANIZATION_ID')
    ];

## Utilisation

Ajouter la facade : 

    use Babaweb\ZohoInvoice\ZohoInvoiceClient;

Par exemple avec la fonction `test` :

    public function test(ZohoInvoiceClient $client) {
        //Vos requêtes ici 
    }

## Fonctions 

Liste des fonctions disponibles :

* __getContactList()__ : Retourne la liste des contacts
* __getInvoiceList($customer_id)__ : Retourne la liste des factures à partir de l'ID du client
* __getInvoiceByID($invoice_id)__ : Retourne la facture dont l'ID est passé en paramètre
* __getInvoicePaymentsByID($invoice_id)__ : Retourne la liste des paiements de facture dont l'ID est passé en paramètre
* __[createItem($parameters)](#createItem)__ : Créer un item à partir des élements en paramètres
* __[createInvoice($parameters)](#createInvoice)__ : Créer une facture à partir des élements en paramètres
* __[createContact($parameters)](#createContact)__ : Créer un contact à partir des élements en paramètres
* __[updateItem($item_id, $parameters)](#updateItem)__ : Modifie un item à partir des élements en paramètres


### Détails des fonctions

#### createItem($parameters) :

    $parameters = [
        //required
        'name' => 'Product 6.1', //Nom de l'item
        'rate' => '300', //Prix unitaire de l'item
        //Optional
        'description' => 'Test product', //Description de l'item
        'tax_id' => 39448000000026222, //ID de la taxe 
        'product_type' => 'service', //Type de l'item
    ];

#### createInvoice($parameters) :

    $parameters = [
        //required
        'customer_id' => 982000000567001, //ID du client
        //Optional
        'invoice_number' => 'INV-00003', //Numéro de la facture
        'discount' => 0, //Réduction appliquée à la facture. Soit en pourcentage (12.5%) ou un montant (190)
        'is_discount_before_tax' => true, //Vrai si la réduction s'applique au HT
    ];

#### createContact($parameters) :

    $parameters = [
        //required
        'contact_name' => 'Bowman and Co', //Nom du contact
        //Optional
        'company_name' => 'Bowman and Co', //Nom de la société
    ];

#### updateItem($item_id, $parameters) :

    $parameters = [
        //required
        'name' => 'Product 6.1', //Nom de l'item
        'rate' => '300', //Prix unitaire de l'item
        //Optional
        'description' => 'Test product', //Description de l'item
        'tax_id' => 39448000000026222, //ID de la taxe 
        'product_type' => 'service', //Type de l'item
    ];

## License

Ce package ZohoInvoice pour Laravel est un logiciel libre sous licence MIT
