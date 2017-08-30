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

## Getting one record
Use the getOne() function. If you'd like to grab one record at an offset,
pass an integer value to get a record at that offset.

```
$bimu->search(["DesSubjects_tab" => "My Subject"], ["irn", "NarTitle"]);
$records = $bimu->getOne();
```

Get a record at an offset of 2.

```
$bimu->search(["DesSubjects_tab" => "My Subject"], ["irn", "NarTitle"]);
$records = $bimu->getOne(2);
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

## Doing an OR search
By default, the criteria array for the search() function will perform
an AND search. If you need to do an OR search, be sure to specify that
in your search function.

```
$bimu->search(
    ["DesSubjects_tab" => "My Subject", "DesSubjects_tab" => "Second subject"],
    ["irn", "NarTitle"],
    "OR"
);
```

## Doing complex searches with combinations of AND/OR
If you need to do a more complex search, with combinations of AND and OR criteria,
use the IMu API documentation here:

http://imu.mel.kesoftware.com/doc/api/php/accessing/searching.html

The IMu API is included in the classpath with BIMu, so you can perform an
IMu API search as shown in the original documentation.

## StreamEOF error
If you're encountering a StreamEOF error from trying to return lots of
records, your best bet is to run two separate queries. First, do a getAll()
and only return the IRN (id) of the records, then loop through all of your returned
IRNs (IDs) and perform a getOne() for each record.
