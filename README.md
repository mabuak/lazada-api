# lazada-api
Interaction with the lazada api for seller

### Installation:
```bash
$ composer require ramadhan/lazada-api:dev-master
```

### Initiate the client
```php
require_once 'vendor/autoload.php';

$lazada = new ramadhan\LazadaClient( [
			'UserID'  => '',
			'ApiKey'  => '',
			'ApiHost' => '',
		] );
```

### Available methods
View source for detailed argument description.

```php
// Get a Brand List
$lazada->GetBrands($limit = 100, $offset = 0);
```