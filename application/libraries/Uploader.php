<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Uploader {

    protected $CI;
    private $dir = './assets/uploads/';
    private $multipleFiles;
    private $FileErrors = array();
    private $overwriteFile = false;
    private $ResizeDimension = [
        'width' => 500,
        'height' => 500,
    ];
    private $dimension = [
        'width' => 500,
        'height' => 500,
        'size' => 0
    ];
    public $deleteAfterResize = false;
    public $ResizeErrors = null;

    public function __construct() {
        // Assign the CodeIgniter super-object
        $this->CI = & get_instance();
        $this->CI->load->helper('string');
        $this->CI->load->library('upload');
    }

    //to specify max width for file upload.. Default: 500
    public function set_width($w) {
        $this->dimension['width'] = $w;
    }

    //to specify max height for file upload.. Default: 500
    public function set_height($h) {
        $this->dimension['height'] = $h;
    }

    //to specify max size for file upload.. Default: infinite
    public function set_size($h) {
        $this->dimension['size'] = $h;
    }

    //to specify max width for file resize.. Default: 500
    public function set_ResizeWidth($w) {
        $this->ResizeDimension['width'] = $w;
    }

    //to specify max height for file resize.. Default: 500
    public function set_ResizeHeight($h) {
        $this->ResizeDimension['height'] = $h;
    }

    //to specify file upload directory
    public function set_directory($path) {
        $this->dir = $path;
    }

    //to create directories
    public function make_directories($path) {
        if (!is_dir($path)) {
            mkdir($path);
        }
    }

    public function upload($img, $resize = false, $delete = false) {
        $result = null;

        //create directory if not existing
        $this->make_directories($this->dir);

        //try to upload image
        $response = $this->upload_handler($img);

        if ($response['status'] == 'ok') {
            $file_name = $response['upload_data']['file_name'];
            $file_ext = $response['upload_data']['file_ext'];

            if ($file_name != null) {
                $result = $this->dir . '/' . $file_name;
            }

            //if delete is true delete all the images in that directory
            //and leave the new image
            if ($delete) {
                $this->delete_all($this->dir);
            }

            //if the image was set to be resized, resize the image...
            if ($resize) {
                $res = $this->resize_image($this->dir . $file_name, $file_ext, $this->deleteAfterResize);
                $result = $res ? ['status' => 'failed', 'msg' => $this->ResizeErrors] : $res;
            }
        } else {
            //return an array of errors and message...
            $result = $response;
        }
        return $result;
    }

    public function upload_multiple($img, $resize = false) {

        $this->make_directories($this->dir);
        $this->make_directories($this->dir . '/thumb');

        $data = [];
        $config['upload_path'] = $this->dir;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = $this->dimension['size'];
        $config['overwrite'] = $this->overwriteFile;

        $num_of_files_to_upload = count($_FILES[$img]['name']);
        for ($f = 0; $f < $num_of_files_to_upload; $f++):
            $_FILES['userfile']['name'] = $_FILES[$img]['name'][$f];
            $_FILES['userfile']['type'] = $_FILES[$img]['type'][$f];
            $_FILES['userfile']['tmp_name'] = $_FILES[$img]['tmp_name'][$f];
            $_FILES['userfile']['size'] = $_FILES[$img]['size'][$f];
            $_FILES['userfile']['error'] = $_FILES[$img]['error'][$f];

            $config['file_name'] = $_FILES[$img]['name'][$f];

            $this->CI->upload->initialize($config);
            if (!$this->CI->upload->do_upload()):
                $data[$f]['error'] = $this->CI->upload->display_errors();
                $data[$f]['upload_data'] = null;

            else:
                $data[$f]['error'] = null;
                $data[$f]['upload_data'] = $this->CI->upload->data();

                if ($resize) {
                    $data[$f]['upload_data']['thumb'] = $this->resize_image(
                            $this->dir . $this->CI->upload->data('file_name'), $this->CI->upload->data('file_ext'));
                } else {
                    $data[$f]['upload_data']['thumb'] = $this->dir . '/' . $this->CI->upload->data('file_name');
                }

            endif;
            $this->multipleFiles = $data;
        endfor;
        return $this;
    }

    //Result process;
    //Returns the entire result as an array
    public function result() {
        return $this->multipleFiles;
    }

    public function FileArray() {

        foreach ($this->multipleFiles as $v) {
            if (isset($v['error']) && !empty($v['error'])) {
                $this->FileErrors[] = $v['error'];
            }
            $files[] = $this->dir . $v['upload_data']['file_name'];
        }

        return $files;
    }

    public function get_errors() {
        return $this->FileErrors;
    }

    public function FileJsonArray() {
        return json_encode($this->FileArray());
    }

    /*
     * Handles the file upload...
     * requirements
     * You need to set the upload directory first before proceeding.
     * currently the max width, height and size are set to infinite
     * TODO in future is to allow the user configure this from their app.
     *
     * @string $img
     */

    private function upload_handler($img, $encrypt = false) {
        $config['upload_path'] = $this->dir;
        $config['allowed_types'] = 'csv|gif|jpg|png|jpeg|pdf|zip|apk|rar';
        $config['max_size'] = 0;
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['overwrite'] = true;
        $config['encrypt_name'] = $encrypt;

        //create default directories
        $this->make_directories($this->dir);

        $this->CI->load->library('upload', $config);

        if ($this->CI->upload->do_upload($img)) {
            $data['status'] = 'ok';
            $data['upload_data'] = $this->CI->upload->data();
        } else {
            $data['status'] = 'failed';
            $data['upload_data'] = null;
            $data['msg'] = $this->CI->upload->display_errors() . '  ' . $this->dir;
        }

        return $data;
    }

    private function resize_image($src, $ext, $del_orig = false) {

        $path = $this->dir;
        $this->imgname = random_string();

        $config['image_library'] = 'gd2';
        $config['new_image'] = './' . $path . $this->imgname . $ext;
        $config['source_image'] = $src;
        $config['create_thumb'] = true;
        $config['maintain_ratio'] = true;
        $config['width'] = $this->ResizeDimension['width'];
        $config['height'] = $this->ResizeDimension['height'];

        $this->CI->image_lib->initialize($config);

        if ($this->CI->image_lib->resize()) {
            if ($del_orig) {
                @unlink($src);
            }
            return $this->dir . $this->imgname . '_thumb' . $ext;
        }
        $this->ResizeErrors = $this->CI->image_lib->display_errors();
        return false;
    }

    private function delete_all($path) {
        $dir = scandir($path);
        //$this->debug($dir);
        foreach ($dir as $file):

            if (file_exists($path . $file) && is_file($path . $file)) {
                unlink($path . $file);
            }

        endforeach;
    }

    private function scan_dir($directory, $recursive = true) {
        $result = array();
        $handle = opendir($directory);
        while ($datei = readdir($handle)) {
            if (($datei != '.') && ($datei != '..') && ($datei != 'thumb.db')) {
                $file = $directory . $datei;
                if (is_dir($file)) {
                    if ($recursive) {
                        $result = array_merge($result, $this->scan_dir($file . '/'));
                    }
                } else {
                    $result[] = $file;
                }
            }
        }
        closedir($handle);
        return $result;
    }

    public function codeToMessage($code) {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "The uploaded file was only partially uploaded";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "No file was uploaded";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Missing a temporary folder";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Failed to write file to disk";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "File upload stopped by extension";
                break;

            default:
                $message = "Unknown upload error";
                break;
        }
        return $message;
    }

    public function debug($array, $dump = false) {
        if ($dump) {
            var_dump($array);
            die();
        }

        echo '<pre>' . print_r($array, true) . '</pre>';
        die();
    }

    public function swooshTest() {
        echo "Swoosh!!!";
    }

}
