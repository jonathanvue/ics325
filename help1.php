<?php 
$file_handle = fopen("help.html", "r");
while (!feof($file_handle)) {
   $line = fgets($file_handle);
   echo $line;
}
fclose($file_handle);
?> 