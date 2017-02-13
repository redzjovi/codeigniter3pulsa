<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class my_image_lib extends CI_Image_lib {
    
    private $CI;
    
    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
        
        ini_set('memory_limit', '-1');
    }
    
    public function __destruct()
    {
        ini_set('memory_limit', '128M');
    }

    /**
    * Compress image
    */
    function compress_image($source_url, $destination_url, $quality = 50)
    {
    	$info = getimagesize($source_url);
     
    	if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
    	elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
    	elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
     
    	//save it
    	imagejpeg($image, $destination_url, $quality);
     
    	//return destination file url
    	return $destination_url;
    }

    /**
    * Crop image and make it square
    */
    public function convert_image_to_square($file_name)
    {
        $height_width_max = get_max_height_width_image($file_name); // get max from height / width
        $this->CI->load->library('image_moo');
        $this->CI->image_moo
        	->load($file_name)
            ->resize($height_width_max, $height_width_max, TRUE)
            ->save($file_name, true);
    } 
    
    
    /*------------------------------------------------------------------------------
    |
    |                             PHParadise source code
    |
    |-------------------------------------------------------------------------------
    |
    | file:             invert image
    | category:         image editing
    |
    | last modified:    Wed, 02 Nov 2005 21:53:34 GMT
    | downloaded:       Fri, 01 Apr 2016 11:15:44 GMT as PHP file
    |
    | code URL:
    | http://phparadise.de/php-code/image-editing/invert-image/
    |
    | description:
    | This PHP function uses the GD library to invert color or black and white images.
    | You can choose wether you want to save the negative of the image or just display
    | it. choose color or black and white output - works with .jpg and .png images if
    | your GD-Library supports it.
    |
    ------------------------------------------------------------------------------*/

    function invert_image($input, $output, $color=false, $type='jpeg')
    {
        if($type == 'jpeg')
        {
            $bild = imagecreatefromjpeg($input);
        }
        else
        {
            $bild = imagecreatefrompng($input);
        }
        $x = imagesx($bild);
        $y = imagesy($bild);

        for($i=0; $i<$y; $i++)
        {
                for($j=0; $j<$x; $j++)
                {
                        $pos = imagecolorat($bild, $j, $i);
                        $f = imagecolorsforindex($bild, $pos);
                        if($color == true)
                        {
                                $col = imagecolorresolve($bild, 255-$f['red'], 255-$f['green'], 255-$f['blue']);
                        }else{
                                $gst = $f['red']*0.15 + $f['green']*0.5 + $f['blue']*0.35;
                                $col = imagecolorclosesthwb($bild, 255-$gst, 255-$gst, 255-$gst);
                        }
                        imagesetpixel($bild, $j, $i, $col);
                }
        }
        if(empty($output)) header('Content-type: image/'.$type);
        if($type == 'jpeg') imagejpeg($bild, $output, 90);
        else imagepng($bild, $output);
    }
    
    /**
    * Remove white space image
    */
    public function remove_whitespace_image($file_name)
    {
        // configure image lib
        $config['image_library'] = 'gd2';
        $config['source_image'] = $file_name;
        $config['new_image'] = $file_name;
        
        // remove whitespace
        $this->initialize($config);
        $this->trim_whitespace();
        $this->clear();
    }
    
    // for a black and withe negative image use like this
    //
    // invert_image($input,'');
    // if you want to save the output instead of just showing it,
    // set the output to the path where you want to save the inverted image
    //
    // invert_image('path/to/original/image.jpg','path/to/save/inverted-image.jpg');
    // if you want to use png you have to set the color flag as
    // true or false and define the imagetype in the function call
    //
    // invert_image('path/to/image.png','',false,'png');

    public function trim_whitespace($color = 'FFFFFF')
    {
        //load the image
        $img = $this->image_create_gd();
    
        //find the size of the borders
        $b_top = 0;
        $b_btm = 0;
        $b_lft = 0;
        $b_rt = 0;
    
        //top
        for(; $b_top < imagesy($img); ++$b_top) {
            for($x = 0; $x < imagesx($img); ++$x) {
                if(imagecolorat($img, $x, $b_top) != '0x'.$color) {
                    break 2; //out of the 'top' loop
                }
            }
        }
    
        //bottom
        for(; $b_btm < imagesy($img); ++$b_btm) {
            for($x = 0; $x < imagesx($img); ++$x) {
                if(imagecolorat($img, $x, imagesy($img) - $b_btm-1) != '0x'.$color) {
                    break 2; //out of the 'bottom' loop
                }
            }
        }
    
        //left
        for(; $b_lft < imagesx($img); ++$b_lft) {
            for($y = 0; $y < imagesy($img); ++$y) {
                if(imagecolorat($img, $b_lft, $y) != '0x'.$color) {
                    break 2; //out of the 'left' loop
                }
            }
        }
    
        //right
        for(; $b_rt < imagesx($img); ++$b_rt) {
            for($y = 0; $y < imagesy($img); ++$y) {
                if(imagecolorat($img, imagesx($img) - $b_rt-1, $y) != '0x'.$color) {
                    break 2; //out of the 'right' loop
                }
            }
        }
    
        //copy the contents, excluding the border
        $newimg = imagecreatetruecolor(
        imagesx($img)-($b_lft+$b_rt), imagesy($img)-($b_top+$b_btm));
    
        imagecopy($newimg, $img, 0, 0, $b_lft, $b_top, imagesx($newimg), imagesy($newimg));
    
        //  Output the image
        if ($this->dynamic_output == TRUE)
        {
            $this->image_display_gd($newimg);
        }
        else
        {
            // Or save it
            if ( ! $this->image_save_gd($newimg))
            {
                return FALSE;
            }
        }
    }
    
}