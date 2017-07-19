# BIMu
A better IMu client.

## Setting up BIMu
Include BIMu using composer:
`composer require itfieldmuseum/bimu`

## Getting records
Use the search() function to search for records, and the get() functions to return
records. With its basic usage, the search function takes a key, value array of criteria
for its first parameter and an array of fields to return for its second parameter.

```
require_once __DIR__ . '/vendor/autoload.php';

use BIMu\BIMu;

$bimu = new BIMu("1.1.1.1", 40107, "enarratives");
$bimu->search(array("DesSubjects_tab" => "My Subject"), array("irn", "NarTitle"));
$records = $bimu->getAll();
```

## Retrieving results hits
Perform a search first, then call the hits function.

```
$bimu->search(array("DesSubjects_tab" => "My Subject"), array("irn", "NarTitle"));
$bimu->hits();
```

## Retrieving results count
You must perform a search, then a get, to be able to access the count.

```
$bimu->search(array("DesSubjects_tab" => "My Subject"), array("irn", "NarTitle"));
$records = $bimu->getAll();
$bimu->count();
```
