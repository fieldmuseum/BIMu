# BIMu
A better IMu client, an attempt to improve upon the IMu API for the EMu database
system, provided by Axiell.

EMu database: http://emu.axiell.com/

IMu API documentation: https://github.com/axiell/imu-api-php

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
Use the get() function. The first parameter is an integer of the number
of records you want to return. The second parameter is how many records
offset you'd like your record retrieval to begin.

If no parameters are passed, the get() function defaults to retrieving
1 record at an offset of 0.

This example returns 50 records at an offset of 200. If you don't
include a search operator, a fuzzy, "contains" search will be done.

```
$bimu->search(["DesSubjects_tab" => "My Subject"], ["irn", "NarTitle"]);
$records = $bimu->get(50, 200);
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
$hits = $bimu->hits();
```

## Retrieving results count
You must perform a search, then a get, to be able to access the count.

```
$bimu->search(["DesSubjects_tab" => "My Subject"], ["irn", "NarTitle"]);
$records = $bimu->getAll();
$count = $bimu->count();
```

## Doing an OR search
By default, the criteria array for the search() function will perform
an AND search. If you need to do an OR search, be sure to specify that
in your search function.

```
$bimu->search(
    ["DesSubjects_tab" => "My Subject", "DesSubjects_tab" => "Second subject"],
    ["irn", "NarTitle"],
    "=",
    "OR"
);
```

## Comparison operators
This operator specifies how the value should search against the field value.
The search operator to use, defaults to null, which is a fuzzy match.

Other options include:  
`=`  (equals)  
`<>` (does not equal)  
`<`  (less than)  
`<=` (less than or equal to)  
`>`  (greater than)  
`>=` (greater than or equal to)

Example search:  
```
$bimu->search(
    ["DesSubjects_tab" => "My Subject", "DesSubjects_tab" => "Second subject"],
    ["irn", "NarTitle"],
    "<>",
    "OR"
);
```

## Doing complex searches with combinations of AND/OR
If you need to do a more complex search, with combinations of AND and OR criteria,
use the IMu API documentation here:

https://github.com/axiell/imu-api-php#3-1-searching-a-module

The IMu API is included in the classpath with BIMu, so you can perform an
IMu API search as shown in the original documentation.

## StreamEOF error
If you're encountering a StreamEOF error from trying to return lots of
records, your best bet is to run two separate queries. First, do a getAll()
and only return the IRN (id) of the records, then loop through all of your returned
IRNs (IDs) and perform a getOne() for each record.

## Updating records
Use the updateOne() function if you'd like to update only one record.  

Use the update() function if you'd like to update ALL of the records
returned from a search.  

Be sure you perform a search() before trying to update any records.  

$valuesToUpdate needs to be an associative array of fields to update
with their record values. $fieldsToReturn is an array of the backend
record fields to return from the update.

```
$bimu->search(["DesSubjects_tab" => "My Subject"], ["irn", "NarTitle"]);
$valuesToUpdate = [
    "NarTitle" => "My new title",
    "SumSubtitle" => "Updated subtitle"
];
$fieldsToReturn = ["irn", "NarTitle", "SumSubtitle"];
$record = $bimu->updateOne($valuesToUpdate, $fieldsToReturn);
```

## Deleting records
Use the delete() function if you'd like to remove records from
an EMu module.  

Be sure you perform a search() before trying to delete records.

$numberOfRecordsToDelete specifies how many records you'd like
to delete from the records returned from the search.

The delete() function returns the number of records deleted.

```
$bimu->search(["DesSubjects_tab" => "My Subject"], ["irn", "NarTitle"]);
$numberRecordsDeleted = $bimu->delete(1);
```
