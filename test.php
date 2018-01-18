<?php
echo time();
$url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
echo $url."   ";
echo "$_SERVER[REQUEST_URL]";
?>