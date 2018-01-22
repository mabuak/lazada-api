# lazada-api

[![Latest Stable Version](https://poser.pugx.org/ramadhan/lazada-api/v/stable)](https://packagist.org/packages/ramadhan/lazada-api) [![Latest Unstable Version](https://poser.pugx.org/ramadhan/lazada-api/v/unstable)](https://packagist.org/packages/ramadhan/lazada-api) [![License](https://poser.pugx.org/ramadhan/lazada-api/license)](https://packagist.org/packages/ramadhan/lazada-api) [![Total Downloads](https://poser.pugx.org/ramadhan/lazada-api/downloads)](https://packagist.org/packages/ramadhan/lazada-api)

Interaction with the lazada api for seller

### Installation:
```bash
$ composer require ramadhan/lazada-api
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
```php
// Use this call to get all or a range of products.
// $parameters = array('Limit' => 20, 'Offset' => 0)
$lazada->GetProducts($parameters = []);
```

### Create product
```php
// Use this call to create products.
$lazada->CreateProduct($xmlContent);
```

### Available methods
View source for detailed argument description.
All methods starting with an uppercase character are also documented in the [Lazada API documentation](https://lazada-sellercenter.readme.io/)

```php
// Use this call to retrieve all product brands in the lazada system.
$lazada->GetBrands($limit = 100, $offset = 0);

// Use this call to retrieve the list of all product categories in the lazada system.
$lazada->GetCategoryTree();

// Use this call to get a list of attributes with options for a given category. 
// It will also display attributes for TaxClass, with their possible values listed as options.
// primaryCategory is Identifier of the category for which the caller wants the list of attributes.
$lazada->GetCategoryAttributes($primaryCategory);

//Use this call to get the returned information from the system for the UploadImages and MigrateImages API.
$lazada->GetResponse($requestId);

//Use this call to migrate multiple images from an external site to Lazada site
$lazada->MigrateImages($imagesUrl);

//Use this call to set the images for an existing product by associating one or more image URLs with it
$lazada->SetImages($xmlContent);

//Use this call to update attributes or SKUs of an existing product.
$lazada->UpdateProduct($xmlContent);

//Use this call to remove an existing product.
$lazada->RemoveProduct($sellerSku = []);

//Use this call to get the customer details for a range of orders.
$lazada->GetOrders($parameters = []);

//Use this call to get the list of items for a single order.
$lazada->GetOrder($orderId);

//Use this call to get the item information of an order.
$lazada->GetOrderItems($orderId);




```