## Dump

> A more convenient way to dump variables than var_dump() or print_r()
> especially for multidimensional arrays

:bulb: **Top tip**: usage for php 5.6

```php
$a = ['art', true, 10, new ZipArchive, array(opendir('.'), false, 10.44)];

$dump = new Dump;

//to display html content

$dump->displayHTML($a);

//to write in an html file (make sure you have write permissions)

$dump->writeHTML($a, '/optional/path/to/YOUR_FILE_NAME_without_extension'));
```