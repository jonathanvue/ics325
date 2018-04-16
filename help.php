<?php
$file_handle = fopen("help.html", "r");
while (!feof($file_handle)) {
   echo fgetss($file_handle);
}
fclose($file_handle);
?>