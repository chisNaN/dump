#######		[ dump ]	#######

a more convenient way to dump variables than var_dump() or print_r
especially for multidimensional arrays

feel free to make any improvements

----------  [ usage for php 5.6 ]   ----------

$o_dump = new Dump;

//only to display on screen

$o_dump->displayHTML(['art', true, 10, new ZipArchive, array(opendir('.'), false, 10.44)]);

echo '<br>';

//this is for writing in a html file

var_dump($o_dump->writeHTML(['art', true, 10, new ZipArchive, array(opendir('.'), false, 10.44)], '/optional/path/to/YOUR_FILE_NAME_without_extension'));