<?php
/* Copyright (C) 2023 	   NextGestion          <contact@nextgestion.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * 	\defgroup   modeldevisfourn     Module modeldevisfourn
 *  \brief      Example of a module descriptor.
 *				Such a file must be copied into /modeldevisfourn/core/modules directory.
 *  \file       /modeldevisfourn/core/modules/modmodeldevisfourn.class.php
 *  \ingroup    modeldevisfourn
 *  \brief      Description and activation file for module modeldevisfourn
 */
include_once DOL_DOCUMENT_ROOT .'/core/modules/DolibarrModules.class.php';


/**
 *  Description and activation class for module modeldevisfourn
 */

class modmodeldevisfourn extends DolibarrModules
{
	/**
	 *   Constructor. Define names, constants, directories, boxes, permissions
	 *
	 *   @param      DoliDB		$db      Database handler
	 */

	function __construct($db)
	{
        global $langs,$conf;

        $this->db = $db;
		
		// Author
		$this->editor_name = 'NextGestion';
		$this->editor_url = 'https://www.nextgestion.com';
		
		// Id for module (must be unique).
		// Use here a free id (See in Home -> System information -> Dolibarr for list of used modules id).
		$this->numero = 19053000; 
		// Key text used to identify module (for permissions, menus, etc...)
		$this->rights_class = 'modeldevisfourn';
		
		// Family can be 'crm','financial','hr','projects','products','ecm','technic','other'
		// It is used to group modules in module setup page
		$this->family = "NextGestion";
		// Module label (no space allowed), used if translation string 'ModuleXXXName' not found (where XXX is value of numeric property 'numero' of module)
		$this->name = preg_replace('/^mod/i','',get_class($this));
		// Module description, used if translation string 'ModuleXXXDesc' not found (where XXX is value of numeric property 'numero' of module)
		$this->description = "Module19053000Desc";
		// Possible values for version are: 'development', 'experimental', 'dolibarr' or version
		$this->version = '1.0';
		// Key used in llx_const table to save module status enabled/disabled (where MYMODULE is value of property name of module in uppercase)
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);
		// Where to store the module in setup page (0=common,1=interface,2=others,3=very specific)
		$this->special = 0;
		// Name of image file used for this module.
		// If file is in theme/yourtheme/img directory under name object_pictovalue.png, use this->picto='pictovalue'
		// If file is in module/img directory under name object_pictovalue.png, use this->picto='pictovalue@module'
		$this->picto='modeldevisfourn@modeldevisfourn';

		$this->module_parts = array(
			'models' => 1
		);

		// Data directories to create when module is enabled.
		// Example: this->dirs = array("/modeldevisfourn/temp");
		$this->dirs = array();

		// Config pages. Put here list of php page, stored into modeldevisfourn/admin directory, to use to setup module.
		// $this->config_page_url = array('setup.php@modeldevisfourn');
		$this->config_page_url = array();

		// Dependencies
		$this->hidden = false;			// A condition to hide module
		// $this->depends = array('modmodeldevisfourn');		// List of modules id that must be enabled if this module is enabled
		$this->depends = array();		// List of modules id that must be enabled if this module is enabled
		$this->requiredby = array();	// List of modules id to disable if this one is disabled
		$this->conflictwith = array();	// List of modules id this module is in conflict with
		$this->phpmin = array(5,0);					// Minimum version of PHP required by module
		$this->need_dolibarr_version = array(3,0);	// Minimum version of Dolibarr required by module
		$this->langfiles = array("modeldevisfourn@modeldevisfourn");
		$this->const = array();
        $this->tabs = array();
        $this->cronjobs = array();
        // Dictionaries
	    if (! isset($conf->modeldevisfourn->enabled))
        {
        	$conf->modeldevisfourn=new stdClass();
        	$conf->modeldevisfourn->enabled=0;
        }
		$this->dictionaries=array();
        $this->boxes = array();			// List of boxes
		$this->rights = array();		// Permission array used by this module
		$r=0;
		
		$this->menu = array();			// List of menus to add
		$r=0;

	}

	/**
	 *		Function called when module is enabled.
	 *		The init function add constants, boxes, permissions and menus (defined in constructor) into Dolibarr database.
	 *		It also creates data directories
	 *
     *      @param      string	$options    Options when enabling module ('', 'noboxes')
	 *      @return     int             	1 if OK, 0 if KO
	 */
	function init($options='')
	{
		global $conf, $langs;
		
		$msql = array();
		
		$langs->load('modeldevisfourn@modeldevisfourn');

		$ret = addDocumentModel('devisfourn', 'supplier_proposal', $langs->trans('model_devisfourn'));
        dolibarr_set_const($this->db,'SUPPLIER_PROPOSAL_ADDON_PDF','devisfourn','chaine');
		
		return $this->_init($msql, $options);
	}

	/**
	 *		Function called when module is disabled.
	 *      Remove from database constants, boxes and permissions from Dolibarr database.
	 *		Data directories are not deleted
	 *
     *      @param      string	$options    Options when enabling module ('', 'noboxes')
	 *      @return     int             	1 if OK, 0 if KO
	 */

	function remove($options='')
	{
		global $langs;

		$sql = array();

		$langs->load('modeldevisfourn@modeldevisfourn');

		$ret = delDocumentModel('devisfourn', 'supplier_proposal', $langs->trans('model_devisfourn'));
        dolibarr_set_const($this->db,'SUPPLIER_PROPOSAL_ADDON_PDF','aurore','chaine');

		return $this->_remove($sql, $options);
	}

}
