<?php

class PluginComputerlabelComputerlabel extends CommonGLPI {

   public function getTabNameForItem(CommonGLPI $item, $withtemplate = 0) {
      if ($item->getType() === 'Computer') {
         return 'Asset Label';
      }

      return '';
   }

   public static function displayTabContentForItem(CommonGLPI $item, $tabnum = 1, $withtemplate = 0) {
      if ($item->getType() !== 'Computer') {
         return false;
      }

      $id = (int)$item->getID();

      echo "<div style='padding:20px'>";
      echo "<a class='btn btn-primary' target='_blank' href='/plugins/computerlabel/front/label.php?id={$id}'>
               🖨 Print Asset Label
            </a>";
      echo "</div>";

      return true;
   }
}
