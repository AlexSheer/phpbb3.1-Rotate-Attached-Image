<?php
/**
*
* @package phpBB Extension - Image rotator
* @copyright (c) 2018 Sheer
* @copyright (c) 2018 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'ACP_IMAGES_ROTATOR_CONFIG'				=> 'Auto rotate images',
	'ACP_IMAGES_ROTATOR_EXPLAIN'			=> 'This function provides automatic correction of the orientation of downloaded images in jpg or jpeg format if the file has EXIF metadata about the image orientation.',
	'IMAGES_RESIZE_DISABLED'				=> 'Automatic rotation is not available. Missing php library <a href="http://php.net/manual/ru/book.exif.php">exif</a>',
	'ACP_IMAGES_ROTATOR_CONFIG_EXPLAIN'		=> 'If you want to enable the auto-reduce function for uploaded images, set <strong> Maximum sizes of uploaded images </strong> below. In this case, the regular size check will be automatically disabled.',
	'ACP_IMAGES_RESIZE_ENABLED'				=> 'At the moment the function of automatic reduction of the sizes of loaded images.
		In this case, automatic rotation of downloaded images will not work.
		If you want to enable automatic rotation, you should turn off image size checking <a href="%s"><strong>here</strong> (Image category settings [Assigned extension group: Images])</a>.',
));
