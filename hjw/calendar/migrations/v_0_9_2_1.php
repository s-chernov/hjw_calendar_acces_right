<?php
/**
*
* @package hjw calendar Extension
* @copyright (c) 2015 hjw
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace hjw\calendar\migrations;

class v_0_9_2_1 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['calendar_version']) && version_compare($this->config['calendar_version'], '0.9.2.1', '>=');
	}

	static public function depends_on()
	{
			return array('\hjw\calendar\migrations\v_0_9_2');
	}

	public function update_data()
	{
		return array(
			array('config.update', array('hjw_calendar_version', '0.9.2.1')),

			array('permission.add', array('a_manage_calendar', true)),
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_manage_calendar')),
			
			array('custom', array(array($this, 'rename_permission_module'))),
		);
	}
	
	public function rename_permission_module()
	{
		$sql = 'UPDATE ' . MODULES_TABLE . "
			SET module_auth = 'ext_hjw/calendar && acl_a_manage_calendar'
			WHERE module_langname = 'ACP_CALENDAR_EVENT_LIST' OR module_langname = 'ACP_CALENDAR_INSTRUCTIONS'";
		$this->sql_query($sql);
	}
}