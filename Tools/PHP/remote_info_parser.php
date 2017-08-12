<?php
////////////////////////////////////////////////////////////////////////////////////////////////////

// This is a very sloppy parsing script for exporting the 488 device scopes from the remotables list into individual files.

////////////////////////////////////////////////////////////////////////////////////////////////////

require 'kint/Kint.class.php';

?><!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Remotables list parsing by Catblack</title>
    <link rel="stylesheet" href="" type="text/css" />
</head>
<body>
start
<hr>


<?php
set_time_limit(7200);
//ini_set('memory_limit', '1024M'); // or you could use 1G
ini_set('memory_limit', '-1');



/*
########## DUMP VARIABLE ###########################
Kint::dump($GLOBALS, $_SERVER); // pass any number of parameters

// or simply use d() as a shorthand:
d($_SERVER);


########## DEBUG BACKTRACE #########################
Kint::trace();
// or via shorthand:
d(1);


############# BASIC OUTPUT #########################
# this will show a basic javascript-free display
s($GLOBALS);


######### WHITESPACE FORMATTED OUTPUT ##############
# this will be garbled if viewed in browser as it is whitespace-formatted only
~d($GLOBALS); // just prepend with the tilde


########## MISCELLANEOUS ###########################
# this will disable kint completely
Kint::enabled(false);

ddd('Get off my lawn!'); // no effect

Kint::enabled(true);
ddd( 'this line will stop the execution flow because Kint was just re-enabled above!' );

*/
$scopekey = 0;
$remotablekey =0;
$linenum=0;
$runtime=date('Ymdgis');
$newfile="";

?>



<?php
//foreach (glob("remotables.txt") as $file) {
    mkdir("Parsetest {$runtime}", 0777, true);

    $file_handle = fopen("20170213remotables.txt", "r");
    while (!feof($file_handle)) {
++$linenum; 
       $line = rtrim(fgets($file_handle));
        $line_array = str_getcsv($line, "\t");
        if (count($line_array) <= 1) {
            //d("blank line");
if(is_resource($newfile)){
   //Handle open
fclose($newfile);
}		
        } elseif (count($line_array) == 2) {
           //scope_domain, scope
           ++$scopekey;


if(!is_resource($newfile)){
   //Handle closed
	$filepath = str_replace("/","_",$line_array[1]);
	$filepath = str_replace(":","_",$filepath);
	$newfile = fopen("Parsetest {$runtime}/{$line_array[0]} {$filepath} Remote Info.txt", "w");
	fwrite($newfile, "Scope\nManufacturer\tModel\n{$line_array[0]}\t{$line_array[1]}\n\nRemotable\tMin\tMax\tInput type\tOutput type\n");

}else{
   //Handle still open
   d("file handle error");
}


           //d($scopekey, $line_array[0], $line_array[1]);
/*
           $database->insert('Scope', [
    'Scope_Domain' => $line_array[0],
    'Scope' => $line_array[1],
    'Scope_Key' => $scopekey
]);
*/        
        } elseif (count($line_array) == 5) {
           ++$remotablekey;
        // item, min, max, input, output

if(is_resource($newfile)){
   //Handle open
	fwrite($newfile, $line."\n");
}else{
   //Handle closed
   d("file line write error {$linenum}");
}



/*
        $database->insert('Remotables', [
    'Remotable_Item' => $line_array[0],
    'Min' => $line_array[1],
    'Max' => $line_array[2],
    'Input' => $line_array[3],
    'Output' => $line_array[4],
    'Scope_Key' => $scopekey,
    'Remotable_Key' => $remotablekey
]);
*/
     //   d($scopekey, $remotablekey);
        }
        
//        echo $line;
    } //while


    fclose($file_handle);

//}


////////////////////////////////////////////////////////////////////////////////////////////////////





d($scopekey,$remotablekey,$linenum,$runtime);

?>



<hr>
end
</body>
</html>


