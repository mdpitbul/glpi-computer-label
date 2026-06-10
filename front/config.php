<?php

include('../../../inc/includes.php');

global $CFG_GLPI;

Session::checkRight('config', UPDATE);

$saved = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   Config::setConfigurationValues('computerlabel', [
      'company_name'          => trim($_POST['company_name'] ?? 'My Company'),
      'show_inventory_number' => isset($_POST['show_inventory_number']) ? 1 : 0,
      'show_serial_number'    => isset($_POST['show_serial_number']) ? 1 : 0,
      'show_qr_code'          => isset($_POST['show_qr_code']) ? 1 : 0,
      'label_width'           => (int)($_POST['label_width'] ?? 50),
      'label_height'          => (int)($_POST['label_height'] ?? 25),
   ]);

   $saved = true;
}

$config = Config::getConfigurationValues('computerlabel');

$company_name = $config['company_name'] ?? 'Company Name';
$show_inv     = (int)($config['show_inventory_number'] ?? 1);
$show_sn      = (int)($config['show_serial_number'] ?? 1);
$show_qr      = (int)($config['show_qr_code'] ?? 1);
$width        = (int)($config['label_width'] ?? 50);
$height       = (int)($config['label_height'] ?? 25);

Html::header('Computer Label', $_SERVER['PHP_SELF'], 'config', 'plugins');

if ($saved) {
   echo "<div class='alert alert-success'>Settings saved</div>";
}

echo "<div class='center'>";
echo "<form method='post' action='".$CFG_GLPI['root_doc']."/plugins/computerlabel/front/config.php'>";
echo "<table class='tab_cadre_fixe'>";
echo "<tr><th colspan='2'>Asset Label Settings</th></tr>";

echo "<tr><td>Company Name</td><td><input type='text' name='company_name' value='".htmlspecialchars($company_name, ENT_QUOTES)."' size='40'></td></tr>";
echo "<tr><td>Label Width (mm)</td><td><input type='number' name='label_width' value='{$width}' min='20' max='150'></td></tr>";
echo "<tr><td>Label Height (mm)</td><td><input type='number' name='label_height' value='{$height}' min='10' max='100'></td></tr>";

echo "<tr><td>Show Inventory Number</td><td><input type='checkbox' name='show_inventory_number' ".($show_inv ? "checked" : "")."></td></tr>";
echo "<tr><td>Show Serial Number</td><td><input type='checkbox' name='show_serial_number' ".($show_sn ? "checked" : "")."></td></tr>";
echo "<tr><td>Show QR Code</td><td><input type='checkbox' name='show_qr_code' ".($show_qr ? "checked" : "")."></td></tr>";

echo "<tr><td colspan='2' class='center'>";
echo Html::submit('Save', ['name' => 'save']);
echo "</td></tr>";

echo "</table>";
Html::closeForm();

echo "</div>";

Html::footer();
