<?php
/**
*
* @package phpBB Extension - Image rotator
* @copyright (c) 2018 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace sheer\image_rotator\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\sheer\image_rotator\acp\main_module',
			'version'	=> '1.0.1',
			'title' => 'ACP_IMAGES_ROTATOR_CONFIG',
			'modes'		=> array(
				'manage'	=> array(
					'title' => 'ACP_IMAGES_ROTATOR_CONFIG',
					'auth' => 'ext_sheer/image_rotator && acl_a_board',
					'cat' => array('ACP_IMAGES_ROTATOR')
				),
			),
		);
	}
}
