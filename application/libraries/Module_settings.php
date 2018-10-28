<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Module_settings
{

    /**
     * page_settings
     * Allow you to set page configuration for all modules
     *
     * @param  mixed $view_file
     * @param  mixed $view_data
     * @param  mixed $data_name
     * @param  mixed $page_title
     * @param  mixed $module
     *
     * @return void
     */
    public function page_settings($view_file, $view_data, $data_name = 'result', $page_title = '', $module = '')
    {
        
        if (empty($data_name))
        {
            $data = $view_data;
        }else{
            $data[$data_name] = $view_data;
        }
        
        $data['view_file'] = $view_file;
        $data['page_title'] = $page_title;
        if ($module != '') {
            $data['module'] = $module;
        }
        return $data;
    }

    /**
     * debug
     * Used as a debugging tool. Primarily used to exit and output content of variables.
     *
     * @param  mixed $array
     *
     * @return void
     */
    public function debug($array, $dump = false)
    {
        if ($dump) {
            var_dump($array);
            die();
        }
        echo "<pre>" . print_r($array, true) . "</pre>";
        die();
    }

    /**
     * get_dropdown_option
     * used to generate drop down list
     *
     * @param  string $name
     * @param  mixed $key
     * @param  mixed $value
     * @param  string $selected
     * @param  mixed $extra
     * @param  array $where | see ci where clause
     * @param  string $model
     *
     * @return void
     */
    public function get_dropdown_option($name, $items, $key, $value, $selected, $extra)
    {
        $data = [];
        
        if (count($items) > 0) {
            $data[null] = '-choose '.$value.'-';
            foreach ($items as $item) {
                $data[$item->$key] = $item->$value;
            }
        } else {
            $data[] = 'No option has been added';
        }
        
        $v = form_dropdown($name, $data, $selected, $extra);
        return $v;
    }

}
