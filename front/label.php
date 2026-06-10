<?php

include('../../../inc/includes.php');

Session::checkRight('computer', READ);

$id = (int)($_GET['id'] ?? 0);

$computer = new Computer();

if (!$id || !$computer->getFromDB($id)) {
   Html::displayErrorAndDie('Computer not found');
}

$config = Config::getConfigurationValues('computerlabel');

$company_name = $config['company_name'] ?? 'Company Name';
$show_inv     = (int)($config['show_inventory_number'] ?? 1);
$show_sn      = (int)($config['show_serial_number'] ?? 1);
$show_qr      = (int)($config['show_qr_code'] ?? 1);
$width        = (int)($config['label_width'] ?? 50);
$height       = (int)($config['label_height'] ?? 25);

$width  = max(20, min(150, $width));
$height = max(10, min(100, $height));

$inventory = $computer->fields['otherserial'] ?? '';
$serial    = $computer->fields['serial'] ?? '';

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host   = $_SERVER['HTTP_HOST'];

$url = $scheme . '://' . $host . $CFG_GLPI['root_doc'] . '/front/computer.form.php?id=' . $id;
$qr_url = 'https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=' . urlencode($url);

$qr_size = min(16, max(10, $height - 6));
$text_width = $show_qr ? max(20, $width - $qr_size - 8) : max(20, $width - 4);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Asset Label</title>

<style>
@page {
   size: A4;
   margin: 10mm;
}

body {
   font-family: Arial, sans-serif;
   margin: 0;
   padding: 0;
}

.no-print {
   margin: 10px;
}

.label {
   width: <?= (int)$width ?>mm;
   height: <?= (int)$height ?>mm;
   border: 1px solid #000;
   box-sizing: border-box;
   padding: 2mm;
   display: flex;
   justify-content: space-between;
   align-items: center;
}

.left {
   width: <?= (int)$text_width ?>mm;
   overflow: hidden;
}

.logo {
   font-size: 12pt;
   font-weight: 900;
   letter-spacing: 0.4px;
   margin-bottom: 3mm;
   white-space: nowrap;
   overflow: hidden;
   text-overflow: ellipsis;
}

.info {
   font-size: 8pt;
   line-height: 1.35;
   font-weight: 700;
   white-space: nowrap;
   overflow: hidden;
   text-overflow: ellipsis;
}

.qrbox {
   width: <?= (int)$qr_size ?>mm;
   height: <?= (int)$qr_size ?>mm;
   display: flex;
   align-items: center;
   justify-content: center;
}

.qrbox img {
   width: <?= (int)$qr_size ?>mm;
   height: <?= (int)$qr_size ?>mm;
}

@media print {
   .no-print {
      display: none;
   }
}
</style>
</head>

<body>

<div class="no-print">
   <button onclick="window.print()">Print</button>
</div>

<div class="label">
   <div class="left">
      <div class="logo"><?= htmlspecialchars($company_name) ?></div>

      <?php if ($show_inv): ?>
         <div class="info">INV: <?= htmlspecialchars($inventory) ?></div>
      <?php endif; ?>

      <?php if ($show_sn): ?>
         <div class="info">SN: <?= htmlspecialchars($serial) ?></div>
      <?php endif; ?>
   </div>

   <?php if ($show_qr): ?>
      <div class="qrbox">
         <img src="<?= htmlspecialchars($qr_url) ?>" alt="QR">
      </div>
   <?php endif; ?>
</div>

<script>
window.onload = function() {
   window.print();
};
</script>

</body>
</html>
