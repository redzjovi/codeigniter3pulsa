<?php

class media_model extends CI_Model {

    public $media_temp_url;
    
    public function __construct()
    {
         parent::__construct();
         $this->media_temp_url = realpath(APPPATH.'../uploads/media/temp/');
    }
    
    public function images_upload($media_file)
    {
        foreach ($media_file["error"] as $key => $value) {
            $file_name = $this->media_temp_url.DS.$media_file["name"][$key];
            $tmp_name = $media_file["tmp_name"][$key];
            
            move_uploaded_file($tmp_name, $file_name); // Upload image to specify path           
            $this->image_lib->remove_whitespace_image($file_name); // Remove white space image
            $this->image_lib->convert_image_to_square($file_name); // Crop image and make it square
            // $this->image_lib->compress_image($file_name, $file_name); // Optimizes PNG file
            echo 'success';
        }
    }
    
}