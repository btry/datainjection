<?php
/*
 * @version $Id$
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2011 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI; if not, write to the Free Software Foundation, Inc.,
 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 --------------------------------------------------------------------------
 */

// ----------------------------------------------------------------------
// Original Author of file: Remi Collet
// Purpose of file:
// ----------------------------------------------------------------------

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginDatainjectionEntityDataInjection extends EntityData
                                         implements PluginDatainjectionInjectionInterface{

   function __construct() {
      $this->table = getTableForItemType(get_parent_class($this));
   }


   static function getTypeName() {
      global $LANG;
      return $LANG['datainjection']['entity'][1];
   }
   
   function isPrimaryType() {
      return false;
   }


   function connectedTo() {
      return array('Entity');
   }


   function getOptions($primary_type = '') {

      $tab = Search::getOptions('Entity');
      //Do some work on linkfields : remove entitydatas_id which is common for all search options
      //copy field as linkfield
      foreach ($tab as $id => $option) {
         if (isset($option['linkfield']) && $option['linkfield'] == 'entitydatas_id') {
            $tab[$id]['linkfield'] = $option['field'];
         }
      }
      //Remove some options because some fields cannot be imported
      $options['ignore_fields'] = array(1, 2, 19);
      $options['displaytype']   = array("multiline_text" => array(16, 17), "dropdown" => array(9));
      $tab = PluginDatainjectionCommonInjectionLib::addToSearchOptions($tab, $options, $this);
      return $tab;
   }

   /**
    * Standard method to add an object into glpi
    *
    * @param values fields to add into glpi
    * @param options options used during creation
    *
    * @return an array of IDs of newly created objects : for example array(Computer=>1, Networkport=>10)
   **/
   function addOrUpdateObject($values=array(), $options=array()) {

      $lib = new PluginDatainjectionCommonInjectionLib($this, $values, $options);
      $lib->processAddOrUpdate();
      return $lib->getInjectionResults();
   }
}

?>