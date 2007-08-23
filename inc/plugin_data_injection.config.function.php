<?php
/*
  ----------------------------------------------------------------------
  GLPI - Gestionnaire Libre de Parc Informatique
  Copyright (C) 2003-2005 by the INDEPNET Development Team.
  
  http://indepnet.net/   http://glpi-project.org/
  ----------------------------------------------------------------------
  
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
  along with GLPI; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
  ------------------------------------------------------------------------
 */

// ----------------------------------------------------------------------
// Original Author of file: Walid Nouh (walid.nouh@atosorigin.com)
// Purpose of file:
// ----------------------------------------------------------------------

if (!defined('GLPI_ROOT')){
	die("Sorry. You can't access directly to this file");
	}
	
function plugin_data_injection_Install() {
	$DB = new DB;
			
	$query="CREATE TABLE `glpi_plugin_data_injection_config` (
  		`ID` int(11) NOT NULL,
  		PRIMARY KEY  (`ID`)
	) ENGINE=MyISAM;";
			
	$DB->query($query) or die($DB->error());
	
	$query="CREATE TABLE `glpi_plugin_data_injection_models` (
		`ID` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`name` VARCHAR( 255 ) NOT NULL ,
		`comments` TEXT NULL ,
		`date_mod` DATETIME NOT NULL ,
		`type` INT( 11 ) NOT NULL DEFAULT '1',
		`device_type` INT( 11 ) NOT NULL DEFAULT '1',
		`behavior_add` INT( 1 ) NOT NULL DEFAULT '1',
		`behavior_update` INT( 1 ) NOT NULL DEFAULT '0',
		`delimiter` VARCHAR( 1 ) NOT NULL DEFAULT ';',
		`FK_entities` INT( 11 ) NOT NULL,
		`header_present` INT( 1 ) NOT NULL DEFAULT '1'
		) ENGINE = MYISAM ;";
	
	$DB->query($query) or die($DB->error());
	
	$query="CREATE TABLE `glpi_plugin_data_injection_mappings` (
		`ID` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`model_id` INT( 11 ) NOT NULL ,
		`type` INT( 11 ) NOT NULL DEFAULT '1',
		`rank` INT( 11 ) NOT NULL ,
		`name` VARCHAR( 255 ) NOT NULL ,
		`value` VARCHAR( 255 ) NOT NULL ,
		`mandatory` INT( 1 ) NOT NULL DEFAULT '0'		
		) ENGINE = MYISAM ;";
	$DB->query($query) or die($DB->error());

	$query="CREATE TABLE `glpi_plugin_data_injection_infos` (
		`ID` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`model_id` INT( 11 ) NOT NULL ,
		`type` int(11) NOT NULL default '9',
		`value` VARCHAR( 255 ) NOT NULL ,
		`mandatory` INT( 1 ) NOT NULL DEFAULT '0'		
		) ENGINE = MYISAM ;";
	$DB->query($query) or die($DB->error());
	
	$query="CREATE TABLE IF NOT EXISTS `glpi_plugin_data_injection_filetype` (
  		`ID` int(11) NOT NULL auto_increment,
  		`name` varchar(255) NOT NULL,
  		`value` int(11) NOT NULL,
  		`class_name` varchar(255) NOT NULL,
  		PRIMARY KEY  (`ID`)
		) ENGINE=MyISAM;";
	$DB->query($query) or die($DB->error());
	
	$query="INSERT INTO `glpi_plugin_data_injection_filetype` (`ID`, `name`, `value`, `class_name`) VALUES 
		(1, 'CSV', 1, 'BackendCSV');";
	$DB->query($query) or die($DB->error());
}


function plugin_data_injection_uninstall() {
	$DB = new DB;
		
	$query = "DROP TABLE `glpi_plugin_data_injection_config`;";
	$DB->query($query) or die($DB->error());
	
	$query = "DROP TABLE `glpi_plugin_data_injection_models`;";
	$DB->query($query) or die($DB->error());

	$query = "DROP TABLE `glpi_plugin_data_injection_mappings`;";
	$DB->query($query) or die($DB->error());

	$query = "DROP TABLE `glpi_plugin_data_injection_infos`;";
	$DB->query($query) or die($DB->error());
	
	$query = "DROP TABLE `glpi_plugin_data_injection_filetype`;";
	$DB->query($query) or die($DB->error());
	
}

function plugin_data_injection_initSession()
{
	if (TableExists("glpi_plugin_data_injection_config") && TableExists("glpi_plugin_data_injection_models") && TableExists("glpi_plugin_data_injection_mappings")  && TableExists("glpi_plugin_data_injection_infos"))
			$_SESSION["glpi_plugin_data_injection_installed"]=1;
}

function isInstall() {
	global $DATAINJECTIONLANG;
	
	if(!isset($_SESSION["glpi_plugin_data_injection_installed"]) || $_SESSION["glpi_plugin_data_injection_installed"]!=1) 
		{
		if(!TableExists("glpi_plugin_data_injection_config")) 
			{
				echo "<div align='center'>";
				echo "<table class='tab_cadre' cellpadding='5'>";
				echo "<tr><th>".$DATAINJECTIONLANG["setup"][1];
				echo "</th></tr>";
				echo "<tr class='tab_bg_1'><td>";
				echo "<a href='plugin_data_injection.install.php'>".$DATAINJECTIONLANG["setup"][3]."</a></td></tr>";
				echo "</table></div>";
			}
		}
}

?>
