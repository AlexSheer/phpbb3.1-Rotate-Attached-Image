<?php
/**
*
* @package phpBB Extension - Image rotator
* @copyright (c) 2015 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace sheer\image_rotator\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
/**
* Assign functions defined in this class to event listeners in the core
*
* @return array
* @static
* @access public
*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.modify_uploaded_file'			=> 'upload_image_rotator',
		);
	}

	/** @var \phpbb\config\config */
	protected $config;

	//** @var string phpbb_root_path */
	protected $phpbb_root_path;

	/**
	* Constructor
	*/
	public function __construct(
		$phpbb_root_path,
		\phpbb\config\config $config
		)
	{
		$this->phpbb_root_path = $phpbb_root_path;
		$this->config = $config;
	}

	public function upload_image_rotator($event)
	{
		$is_image = $event['is_image'];
		$filedata = $event['filedata'];
		$destination_file = $this->phpbb_root_path . $this->config['upload_path'] . '/' . $filedata['physical_filename'];
		if ($is_image)
		{
			if (function_exists('exif_imagetype') && ($filedata['extension'] == 'jpg' || $filedata['extension'] == 'jpeg'))
			{
				$exif = exif_read_data($destination_file, 0, true);
				if(isset($exif['IFD0']['Orientation']))
				{
					$source = imagecreatefromjpeg($destination_file);
					$rotate = true;

					switch($exif['IFD0']['Orientation'])
					{
						case 3: // 180 rotate left
							$rotate = imagerotate($source, 180, 0);
							break;
						case 6: // 90 rotate right
							$rotate = imagerotate($source, -90 ,0);
							break;
						case 8: // 90 rotate left
							$rotate = imagerotate($source, 90, 0);
							break;
						case 8: // 90 rotate left
							$rotate = imagerotate($source, 90, 0);
							break;
						default:
							$rotate = false;
							break;
					}
					if($rotate)
					{
						unlink($destination_file);
						imagejpeg($rotate, $destination_file, 100);
					}
				}
			}
		}
	}
}
