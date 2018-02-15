<?php
/**
*
* info_acp_admimages [Russian]
*
* @package Request Pattern
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
	'ACP_IMAGES_ROTATOR_CONFIG'				=> 'Автоповорот изображений',
	'ACP_IMAGES_ROTATOR_EXPLAIN'			=> 'Данная функция обеспечивает автоматическую коррекцию ориентации загружаемых изображений в формате jpg или jpeg в случае, если в файле имеются EXIF метаданные об ориентации изображения.',
	'IMAGES_RESIZE_DISABLED'				=> 'Автоматический поворот недоступен. Отсутствует библиотека php <a href="http://php.net/manual/ru/book.exif.php">exif</a>',
	'ACP_IMAGES_ROTATOR_CONFIG_EXPLAIN'		=> 'Если вы желаете включить функцию автоматического уменьшения размеров загружаемых изображений, установите <strong>Максимальные размеры загружаемых рисунков</strong> ниже. В этом случае штатная проверка размеров будет автоматически отключена.',
	'ACP_IMAGES_RESIZE_ENABLED'				=> 'В данный момент на конференции включена функция автоматического уменьшения размеров загружаемых изображений.
		В этом случае автоматический поворот загружаемых изображений работать не будет.
		Если вы желаете включить автоматический поворот, следует отключить проверку размеров изображений <a href="%s"><strong>здесь</strong> (Настройки категории изображений [назначенная группа расширений: Изображения])</a>.',
));
