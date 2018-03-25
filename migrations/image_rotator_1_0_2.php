<?php
/**
*
* @package phpBB Extension - Image rotator
* @copyright (c) 2018 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace sheer\image_rotator\migrations;

class image_rotator_1_0_2 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['image_rotator_version']) && version_compare($this->config['image_rotator_version'], '1.0.2', '>=');
	}

	static public function depends_on()
	{
		return array('\sheer\image_rotator\migrations\image_rotator_1_0_1');
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
			array('config.update', array('image_rotator_version', '1.0.2')),
		);
	}
}