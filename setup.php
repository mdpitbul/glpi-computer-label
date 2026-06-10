<?php

define('PLUGIN_COMPUTERLABEL_VERSION', '0.2.0');

require_once __DIR__ . '/inc/computerlabel.class.php';

function plugin_init_computerlabel() {
   global $PLUGIN_HOOKS;

   $PLUGIN_HOOKS['csrf_compliant']['computerlabel'] = true;
   $PLUGIN_HOOKS['config_page']['computerlabel'] = 'front/config.php';

   Plugin::registerClass('PluginComputerlabelComputerlabel', [
      'addtabon' => ['Computer']
   ]);
}

function plugin_version_computerlabel() {
   return [
      'name'           => 'Computer Label',
      'version'        => PLUGIN_COMPUTERLABEL_VERSION,
      'author'         => 'Andrey Sennikov',
      'license'        => 'GPLv2+',
      'homepage'       => '',
      'requirements'   => [
         'glpi' => [
            'min' => '11.0.0',
            'max' => '11.99.99',
         ]
      ]
   ];
}

function plugin_computerlabel_check_prerequisites() {
   return true;
}

function plugin_computerlabel_check_config() {
   return true;
}
