# lazada-api

# Amazon Marketplace Webservices
[![Latest Stable Version](https://poser.pugx.org/ramadhan/lazada-api/v/stable)](https://packagist.org/packages/ramadhan/lazada-api) [![Latest Unstable Version](https://poser.pugx.org/ramadhan/lazada-api/v/unstable)](https://packagist.org/packages/ramadhan/lazada-api) [![License](https://poser.pugx.org/ramadhan/lazada-api/license)](https://packagist.org/packages/ramadhan/lazada-api) [![Total Downloads](https://poser.pugx.org/ramadhan/lazada-api/downloads)](https://packagist.org/packages/ramadhan/lazada-api)

Interaction with the lazada api for seller

### Installation:
```bash
$ composer require ramadhan/lazada-api:dev-master
```

### Initiate the client
```php
require_once 'vendor/autoload.php';

$lazada = new ramadhan\LazadaClient( [
			'UserID'  => 'look@me.com',
			'ApiKey'  => 'b1bdb357ced10fe4e9a69840cdd4f0e9c03d77fe',
			'ApiHost' => 'https://api.sg.ali-lazada.com/',
		] );
```

### Get products
Use this call to get all or a range of products.

To get the parameters, you can check this link
https://lazada-sellercenter.readme.io/docs/getproducts

```php
// $parameters = array('Limit' => 20, 'Offset' => 0)
$lazada->GetProducts($parameters = array());
```

### Available methods
View source for detailed argument description.

```php
// Use this call to retrieve all product brands in the lazada system.
$lazada->GetBrands($limit = 100, $offset = 0);

// Use this call to retrieve the list of all product categories in the lazada system.
$lazada->GetCategoryTree();

// Use this call to get a list of attributes with options for a given category. 
// It will also display attributes for TaxClass, with their possible values listed as options.
// primaryCategory is Identifier of the category for which the caller wants the list of attributes.
$lazada->GetCategoryAttributes($primaryCategory);
```