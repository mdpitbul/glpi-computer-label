<?php

function plugin_computerlabel_install() {
   Config::setConfigurationValues('computerlabel', [
      'company_name'          => 'Company Name',
      'show_inventory_number' => 1,
      'show_serial_number'    => 1,
      'show_qr_code'          => 1,
      'label_width'           => 50,
      'label_height'          => 25,
   ]);

   return true;
}

function plugin_computerlabel_uninstall() {
   Config::deleteConfigurationValues('computerlabel', [
      'company_name',
      'show_inventory_number',
      'show_serial_number',
      'show_qr_code',
      'label_width',
      'label_height',
   ]);

   return true;
}
