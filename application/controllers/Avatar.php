<?php

class Avatar extends Reim_Controller {
    // maximum image file length 10MB
    const MAX_IMAGE_LENGTH = 10485760;

    static $supported_image_types = [ IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WBMP ];

    public function __construct() {
        parent::__construct();

        $this->load->model('items_model');
    }

    public function upload() {
        $file = $this->_get_upload_file();
        if ($file == FALSE) {
            die();
        }
        $imgfile = tempnam(sys_get_temp_dir(), 'tmp');
        $this->_save_uploaded_image($file['tmp_name'], $imgfile);

        $key = sha1($imgfile);
        $this->session->set_userdata($key, $imgfile);

        $this->output->set_output(json_encode([
            'key' => $key,
            'url' => "/avatar/preview/$key",
        ]));
    }

    private function _get_upload_file($name = 'file') {
        log_message("debug", json_encode($_FILES));
        if (!isset($_FILES[$name]) or
            !is_uploaded_file($_FILES[$name]['tmp_name']) or
            $_FILES[$name]['error'] != 0) {
            return FALSE;
        }

        return $_FILES[$name];
    }

    private function _save_uploaded_image($source, $destination) {
        if (filesize($source) > self::MAX_IMAGE_LENGTH) {
            $this->output->set_status_header(400);
            die('The file was too large.');
        }

        $info = @getimagesize($source);
        if ($info === FALSE || !in_array($info[2], self::$supported_image_types)) {
            $this->output->set_status_header(400);
            die('Invalid file type.');
        }

        $imagetype = $info[2];
        $exif = exif_read_data($source);

        $image = $this->_image_create_from($source, $imagetype);
        $rotated_image = $this->_image_exif_rotate($image, $exif);
        $this->_image_save_to($rotated_image, $imagetype, $destination);

        @imagedestroy($rotated_image);
        @imagedestroy($image);
    }

    private function _image_exif_rotate($image, $exif) {
        if (!empty($exif['Orientation'])) {
            switch($exif['Orientation']) {
            case 1:
                break;
            case 2:
                $image = imageflip($image, IMG_FLIP_HORIZONTAL);                
                break;
            case 3:
                $image = imagerotate($image, 180, 0);
                break;
            case 4:
                $image = imageflip($image, IMG_FLIP_HORIZONTAL);
                $image = imagerotate($image, 180, 0);
                break;
            case 5:
                $image = imageflip($image, IMG_FLIP_VERTICAL);
                $image = imagerotate($image, -90, 0);
                break;
            case 6:
                $image = imagerotate($image, -90, 0);
                break;
            case 7:
                $image = imageflip($image, IMG_FLIP_VERTICAL);
                $image = imagerotate($image, 90, 0);
                break;
            case 8:
                $image = imagerotate($image, 90, 0);
                break;
            }
        }

        return $image;
    }

    private function _image_create_from($filename, $imagetype) {
        assert(in_array($imagetype, self::$supported_image_types));

        switch($imagetype) {
        case IMAGETYPE_JPEG:
            return imagecreatefromjpeg($filename);
        case IMAGETYPE_PNG:
            return imagecreatefrompng($filename);
        case IMAGETYPE_GIF:
            return imagecreatefromgif($filename);
        case IMAGETYPE_WBMP:
            return imagecreatefromwbmp($filename);
        }
    }

    private function _image_save_to($image, $imagetype, $filename) {
        assert(in_array($imagetype, self::$supported_image_types));

        ob_start();
        switch($imagetype) {
        case IMAGETYPE_JPEG:
            imagejpeg($image);
            break;
        case IMAGETYPE_PNG:
            imagepng($image);
            break;
        case IMAGETYPE_GIF:
            imagegif($image);
            break;
        case IMAGETYPE_WBMP:
            imagewbmp($image);
            break;
        }

        $content = ob_get_contents();
        ob_end_clean();

        file_put_contents($filename, $content);
    }
    
    public function preview($key) {
        if ($this->input->method(true) !== 'GET') {
            show_404();
        }
        $imagefile = $this->session->userdata($key);
        if ($imagefile == NULL || !file_exists($imagefile)) {
            show_404();
        }
        $info = @getimagesize($imagefile);
        if ($info === FALSE || !in_array($info[2], self::$supported_image_types)) {
            show_404();
        }

        $content = file_get_contents($imagefile);
        $this->output->set_content_type($info['mime'])
            ->set_output($content);
    }

    public function crop($key) {
        $imagefile = $this->session->userdata($key);
        if ($imagefile == NULL || !file_exists($imagefile)) {
            show_404();
        }
        $info = @getimagesize($imagefile);
        if ($info === FALSE || !in_array($info[2], self::$supported_image_types)) {
            show_404();
        }
        $imagewidth = $info[0];
        $imageheight = $info[1];
        $imagetype = $info[2];

        $x = intval($this->input->post('x'));
        $y = intval($this->input->post('y'));
        $width = intval($this->input->post('width'));
        $height = intval($this->input->post('height'));

        if ($width != $height || $width < 1) {
            $this->output->set_status_header(400)
                ->output('Invalid parameter width and height');
            return;
        }

        if ($x + $width > $imagewidth) {
            $this->output->set_status_header(400)
                ->output('Invalid parameter x and width');
            return;
        }

        if ($y + $height > $imageheight) {
            $this->output->set_status_header(400)
                ->output('Invalid parameter y and height');
            return;
        }

        // crop
        $image = $this->_image_create_from($imagefile, $imagetype);
        if (PHP_VERSION_ID < 50612) {
            $crop_image = imagecreatetruecolor($width, $height);
            imagecopy($crop_image, $image, 0, 0, $x, $y, $width, $height);
        } else {
            $crop_image = imagecrop($image, [
                'x' => $x,
                'y' => $y,
                'width' => $width,
                'height' => $height,
            ]);
        }

        // resize
        if ($width > 600) {
            $tmpimage = $crop_image;
            $crop_image = imagecreatetruecolor(600, 600);

            imagecopyresampled($crop_image, $tmpimage, 0, 0, 0, 0, 600, 600, $width, $height);
            imagedestroy($tmpimage);
        }

        $crop_imagefile = tempnam(sys_get_temp_dir(), 'tmp');
        $this->_image_save_to($crop_image, $imagetype, $crop_imagefile);

        // clean-up
        @imagedestroy($crop_image);
        @imagedestroy($image);
        
        $img = $this->items_model->upload_image($crop_imagefile, 0);
        // clean-up if success
        if ($img['status']) {
            @unlink($crop_imagefile);
            @unlink($imagefile);
        }

        $this->output->set_output(json_encode($img));
    }
}