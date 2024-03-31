<?php

//Application default settings

//Error repoting
error_reporting(E_ALL);
ini_set('display_erros' , '1');
ini_set('display_startup_erros', '1');

//Timezone
date_default_timezone_set('America/Mexico_City');

$settings = [];

$settings = (require __DIR__ . '/env.php')($settings);

return $settings;