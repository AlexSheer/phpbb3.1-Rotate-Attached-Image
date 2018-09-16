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
				$exif = @exif_read_data($destination_file, 0, true);
				if (isset($exif['THUMBNAIL']) && $exif['THUMBNAIL']['Orientation'] == 1)
				{
					$rotate = false;
					$flip = false;
					unset($exif['IFD0']['Orientation']);
				}
				if (isset($exif['IFD0']['Orientation']))
				{
					$source = imagecreatefromjpeg($destination_file);
					$rotate = true;
					$flip = false;

					switch($exif['IFD0']['Orientation'])
					{
						case 2: // flip horizontal
							$flip = imageflip($source, IMG_FLIP_HORIZONTAL);
							$rotate = false;
						break;
						case 3: // 180 rotate left
							$rotate = imagerotate($source, 180, 0);
						break;
						case 4: // flip vertical
							$flip = imageflip($source, IMG_FLIP_VERTICAL);
							$rotate = false;
						break;
						case 5: // flip horizontal and 90 rotate left
							$flip = imageflip($source, IMG_FLIP_HORIZONTAL);
							if ($flip)
							{
								$flip = false;
								$rotate = imagerotate($source, 90, 0);
							}
						break;
						case 6: // 90 rotate right
							$rotate = imagerotate($source, -90 ,0);
						break;
						case 7: // flip horizontal and 90 rotate right
							$flip = imageflip($source, IMG_FLIP_HORIZONTAL);
							if ($flip)
							{
								$flip = false;
								$rotate = imagerotate($source, -90, 0);
							}
						break;
						case 8: // 90 rotate left
							$rotate = imagerotate($source, 90, 0);
						break;
						case 1: // no break here
						default: // nothing to do
							$rotate = $flip = false;
						break;
					}
					if ($rotate)
					{
						unlink($destination_file);
						imagejpeg($rotate, $destination_file, 100);
						imagedestroy($rotate);
					}
					else if ($flip)
					{
						imagejpeg($source, $destination_file, 100);
					}
					imagedestroy($source);
				}
			}

			if ($this->config['rotate_img_max_width'] && $this->config['rotate_img_max_height'])
			{
				$this->upload_image_resizer($destination_file, $filedata['extension']);
			}
		}
	}

	public function upload_image_resizer($destination_file, $ext)
	{
		$quality = 90;
		$size = getimagesize($destination_file);
		$width = $size[0];
		$height = $size[1];
		if ($height > $this->config['rotate_img_max_height'] || $width > $this->config['rotate_img_max_width'])
		{
			$int_factor = min(($this->config['rotate_img_max_width'] / $width), ($this->config['rotate_img_max_height'] / $height));
			$width = round($width * $int_factor);
			$height = round($height * $int_factor);
			$destination = imagecreatetruecolor($width, $height);
			switch ($ext)
			{
				case 'jpg':
				case 'jpeg':
					@ini_set('gd.jpeg_ignore_warning', 1);
					$source = imagecreatefromjpeg($destination_file);
					imagecopyresampled($destination, $source, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
					imagejpeg($destination, $destination_file, $quality);
				break;
				case 'png':
					@imagealphablending($destination, false);
					@imagesavealpha($destination, true);
					$source = imagecreatefrompng($destination_file);
					imagecopyresampled($destination, $source, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
					imagepng($destination, $destination_file);
				break;
				case 'gif':
					$source = imagecreatefromgif($this->destination_file);
					$trnprt_indx = imagecolortransparent($source);
					if ($trnprt_indx >= 0) //transparent
					{
						$trnprt_color = imagecolorsforindex($source, $trnprt_indx);
						$trnprt_indx = imagecolorallocate($destination, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
						imagefill($destination, 0, 0, $trnprt_indx);
						imagecolortransparent($destination, $trnprt_indx);
					}
					imagecopyresampled($destination, $source, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
					imagegif($destination, $destination_file);
				break;
				default:
				break;
			}
			imagedestroy($destination);
		}
	}
}
