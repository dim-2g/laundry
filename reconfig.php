<?php

$db_host = 'localhost';
$db_name = 'laundry';
$db_user = 'homestead';
$db_pass = 'secret';

$document_root = $_SERVER['DOCUMENT_ROOT'].'/';

$config1_path = $document_root . 'config.core.php';
$config1 = file_get_contents($config1_path);
if (empty($config1)) die('Error 1');
preg_match("#'MODX_CORE_PATH',\s*'([^']+)core/'#siU",$config1,$aM);
$replace_path = $aM[1];
echo "<p><small>Будет произведена замена путей с $replace_path на $document_root</small></p>";
$config1 = str_replace($replace_path, $document_root, $config1);
if (file_put_contents($config1_path, $config1) ) {
    echo "<p><small>Файл $config1_path - OK</small></p>";
}


$config2_path = $document_root . 'connectors/config.core.php';
$config2 = file_get_contents($config2_path);
$config2 = str_replace($replace_path, $document_root, $config2);
if (file_put_contents($config2_path, $config2) ) {
    echo "<p><small>Файл $config2_path - OK</small></p>";
}




$config3_path = $document_root . 'manager/config.core.php';
$config3 = file_get_contents($config3_path);
$config3 = str_replace($replace_path, $document_root, $config3);
if (file_put_contents($config3_path, $config3) ) {
    echo "<p><small>Файл $config3_path - OK</small></p>";
}




$config4_path = $document_root . 'core/config/config.inc.php';
$config4 = file_get_contents($config4_path);

$config4 = str_replace($replace_path, $document_root, $config4);
$config4 = preg_replace("#(database_server = ')[^']+(';)#siU", "$1".$db_host."$2", $config4);
$config4 = preg_replace("#(dbase\s*=\s*')[^']+(';)#siU", "$1".$db_name."$2", $config4);
$config4 = preg_replace("#(database_user\s*=\s*')[^']+(';)#siU", "$1".$db_user."$2", $config4);
$config4 = preg_replace("#(database_password\s*=\s*')[^']+(';)#siU", "$1".$db_pass."$2", $config4);
$config4 = preg_replace("#(mysql:host=)[^;]+(;dbname=)[^;]+(;charset=.*;)#siU","$1".$db_host."$2".$db_name."$3", $config4);
if (file_put_contents($config4_path, $config4) ) {
    echo "<p><small>Файл $config4_path - OK</small></p>";
}

echo "<p><small>Удаляем файлы кеша</small></p>";
removeDirectory($document_root.'core/cache/');
echo "<p><small>Готово</small></p>";


function removeDirectory($dir) {
if ($objs = glob($dir."/*")) {
   foreach($objs as $obj) {
     is_dir($obj) ? removeDirectory($obj) : unlink($obj);
   }
}
rmdir($dir);
}
