#### INSTALAÇÃO

run
```bash
composer require prismo-smartpro/paginator
```

#### Usage examples

```php
<?php

require "vendor/autoload.php";

use SmartPRO\Technology\Paginator;

$test = new Test();

$paginator = new Paginator("https://github.dev/paginator/?page=");
$paginator->create($test->rowsCount(), 6);
$paginator->setNext("»");
$paginator->setPrev("«");

$data = $test->find()->limite($paginator->limite())->offset($paginator->offset())->fetch(true);

foreach ($data as $item){
   //continue
}

var_dump($paginator->currentPage());
//output = Página 1 de 7 
```