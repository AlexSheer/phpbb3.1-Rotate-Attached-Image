<?php
/**
*
* @package phpBB Extension - Image rotator
* @copyright (c) 2018 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace sheer\imagerotator\migrations;

class image_rotator_1_0_1 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['image_rotator_version']) && version_compare($this->config['image_rotator_version'], '1.0.1', '>=');
	}

	static public function depends_on()
	{
		return array('\sheer\imagerotator\migrations\image_rotator_1_0_0');
	}

	public function update_schema()
	{
		return array(
		);
	}

	public function revert_schema()
	{
		return array(
		);
	}

	public function update_data()
	{
		return array(
			// Current version
			array('config.update', array('image_rotator_version', '1.0.1')),
			array('config.update', array('img_max_width', 0)),
			array('config.update', array('img_max_height', 0)),
			array('config.add', array('rotate_img_max_width', 0)),
			array('config.add', array('rotate_img_max_height', 0)),
			// ACP
			array('module.add', array('acp', 'ACP_ATTACHMENTS', array(
				'module_basename'	=> '\sheer\imagerotator\acp\main_module',
				'module_langname'	=> 'ACP_IMAGES_ROTATOR_CONFIG',
				'module_mode'		=> 'config',
				'module_auth'		=> 'ext_sheer/imagerotator && acl_a_board',
				'module_enabled'	=> true,
			))),
		);
	}
}