<?php
/**
*
* @package phpBB Extension - Image rotator
* @copyright (c) 2018 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace sheer\image_rotator\acp;

class main_module
{
	var $p_master;
	var $u_action;

	function __construct(&$p_master)
	{
		$this->p_master = &$p_master;
	}

	function main($id, $mode)
	{
		global $user, $template, $request, $config, $phpbb_admin_path, $phpEx;

		$this->tpl_name = 'acp_image_rotator_body';
		$this->page_title = $user->lang('ACP_IMAGES_ROTATOR_CONFIG');
		$user->add_lang('acp/attachments');

		$limit_width	= $request->variable('limit_width', $config['rotate_img_max_width']);
		$limit_height	= $request->variable('limit_height', $config['rotate_img_max_height']);
		$url = $this->u_action;

		$form_key = 'acp_time';
		add_form_key($form_key);
		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('acp_time'))
			{
				trigger_error('FORM_INVALID');
			}
			set_config('rotate_img_max_width', $limit_width);
			set_config('rotate_img_max_height', $limit_height);
			if ($limit_width || $limit_height)
			{
				set_config('img_max_height', 0);
				set_config('img_max_width', 0);
			}
			trigger_error($user->lang['CONFIG_UPDATED'] . adm_back_link($this->u_action));
		}

		$url = append_sid("{$phpbb_admin_path}index.$phpEx", 'i=acp_attachments&icat=9&mode=attach');

		$template->assign_vars(array(
			'U_ACTION'						=> $this->u_action,
			'LIMIT_WIDTH'					=> $limit_width,
			'LIMIT_HEIGHT'					=> $limit_height,
			'S_RESIZE_ENABLED'				=> ($config['img_max_width'] || $config['img_max_height']) ? true : false,
			'L_ACP_IMAGES_RESIZE_ENABLED'	=> sprintf($user->lang['ACP_IMAGES_RESIZE_ENABLED'], $url),
			'S_IMAGES_RESIZE_ENABLED'		=> (function_exists('exif_imagetype')) ? true : false,
		));
	}
}
