# BIMu
A better IMu client, an attempt to improve upon the IMu API for the EMu database
system, provided by Axiell.

EMu database: http://emu.axiell.com/

IMu API documentation: http://imu.mel.kesoftware.com/doc/api/php/index.html

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
$bimu->search(["DesSubjects_tab" => "My Subject"], ["irn", "NarTitle"]);
$records = $bimu->getAll();
```

## Getting a certain number of records
Use the get() function.

```
$bimu->search(["DesSubjects_tab" => "My Subject"], ["irn", "NarTitle"]);
$records = $bimu->get(50);
```

## Retrieving results hits
Perform a search first, then call the hits function.

```
$bimu->search(["DesSubjects_tab" => "My Subject"], ["irn", "NarTitle"]);
$bimu->hits();
```

## Retrieving results count
You must perform a search, then a get, to be able to access the count.

```
$bimu->search(["DesSubjects_tab" => "My Subject"], ["irn", "NarTitle"]);
$records = $bimu->getAll();
$bimu->count();
```

## StreamEOF error
If you're encountering a StreamEOF error from trying to return lots of
records, your best bet is to run two separate queries. First, do a getAll()
and only return the IRN (id) of the records, then loop through all of your returned
IRNs (IDs) and perform a getOne() for each record.
