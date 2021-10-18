<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function ee($str, $exit = true)
{
    echo "<pre>";
    print_r($str);
    if ($exit) {
        exit;
    }
}

function getThis()
{
    $CI = &get_instance();
    return $CI;
}

function lQ($exit = true)
{
    e(getThis()->db->last_query(), $exit);
}

function curUsrId()
{
    return getThis()->session->userdata('USER_ID');
}

function gp($index, $array = [], $default = null)
{
    return isset($array[$index]) ? $array[$index] : $default;
}

function getMonthsNameFromNumSq($mnth_sq = [])
{
    $mnth_names = [];
    $mnth_names[1] = 'Jan';
    $mnth_names[] = 'Feb';
    $mnth_names[] = 'Mar';
    $mnth_names[] = 'Apr';
    $mnth_names[] = 'May';
    $mnth_names[] = 'Jun';
    $mnth_names[] = 'Jul';
    $mnth_names[] = 'Aug';
    $mnth_names[] = 'Sep';
    $mnth_names[] = 'Oct';
    $mnth_names[] = 'Nov';
    $mnth_names[] = 'Dec';
    $ret_names = [];
    if ($mnth_sq) {
        foreach ($mnth_sq as $mn_num) {
            if (isset($mnth_names[$mn_num])) {
                $ret_names[] = $mnth_names[$mn_num];
            }
        }
    }
    return $ret_names;
}

function getGraphMonthName($mnth_sq = [])
{
    $ret_names = [];
    $mnth_names = [];
    $mnth_names[1] = 'Jan';
    $mnth_names[] = 'Feb';
    $mnth_names[] = 'Mar';
    $mnth_names[] = 'Apr';
    $mnth_names[] = 'May';
    $mnth_names[] = 'Jun';
    $mnth_names[] = 'Jul';
    $mnth_names[] = 'Aug';
    $mnth_names[] = 'Sep';
    $mnth_names[] = 'Oct';
    $mnth_names[] = 'Nov';
    $mnth_names[] = 'Dec';
    if ($mnth_sq) {
        foreach ($mnth_sq as $mnth) {
            $mnth = explode('-', $mnth);
            $tmp_mn = '';
            if (isset($mnth_names[$mnth[1]])) {
                $tmp_mn = $mnth_names[$mnth[1]];
            }
            $ret_names[] = '' . $mnth[0] . '-' . $tmp_mn . '';
        }
    }
    return $ret_names;
}

function calibrateCategoryDepth()
{
    return categoryParentTree(70, 0, [0 => 70]);
}

function categoryParentTree($category_id, $level, $levels = array())
{
    $CI = &get_instance();
    $data = $CI->db
        ->select('parent_id')
        ->from('category')
        ->where('id', $category_id)
        ->get()->row_array();
    if (isset($data['parent_id']) && $data['parent_id']) {
        $level++;
        $levels[$level] = $data['parent_id'];
        return categoryParentTree($data['parent_id'], $level, $levels);
    } else {
        return $levels;
    }
}

function getpostcodes($id)
{
    $CI = &get_instance();
    $data = $CI->db->select('t1.postcode,t1.id')
        ->from('postcodelatlng t1')
        ->join('postcodes_asigned t2', 't2.post_is = t1.id')
        ->join('distribution t3', 't3.id = t2.dest_id')
        ->where('t3.id', $id)
        ->get()->result_array();
    return $data;
}

function createElementHtmlOld($page_id, $row_id, $element_id, $content)
{
    $CI = &get_instance();
    $CI->load->library('parser');

    $element_template = $CI->db->select('element_template')->where('id', $element_id)->get('pagebuilder_elements')->row_array();
    $content = json_decode($content, true);
    $contentArr = [];
    foreach ($content as $key => $value) {
        $contentArr['{' . $key . '}'] = $value;
    }

    $template_content['TEMPLATE_CONTENT'] = str_replace(array_keys($contentArr), array_values($contentArr), $element_template);
    return $template_content['TEMPLATE_CONTENT']['element_template'];
}

function createElementHtml($page_id, $row_id, $element_id, $content)
{
    $CI = &get_instance();
    $content = json_decode($content, true);
    $element_template = $CI->db->select('element_template')->where('id', $element_id)->get('pagebuilder_elements')->row_array();
    $columnData = $CI->db->select('id')->where('page_id', $page_id)->where('row_id', $row_id)->where('element_id', $element_id)->get('pagebuilder_columns')->row_array();

    $filename = "page_block_{$columnData['id']}.php";
    // $filepath = str_replace('admin\\', '', FCPATH) . "/" . "application/" . "views/themes/" . THEME . "/compiled/page_blocks/$filename";
    $filepath = str_replace('admin/', '', FCPATH) . "/" . "application/" . "views/themes/" . THEME . "/compiled/page_blocks/$filename";
    $filepath1 = APPPATH . "views/page_blocks/$filename";

    $contentArr = [];
    foreach ($content as $key => $value) {
        $contentArr[$key] = $value;
    }
    createMyCss();
    $inner['block'] = $contentArr;
    file_put_contents($filepath, $element_template);
    file_put_contents($filepath1, $element_template);
    $view = $CI->load->view("page_blocks/$filename", $inner);
    return $view;
}

function getPageBuilderElementById($id)
{
    $CI = &get_instance();
    $data = $CI->db->where('id', $id)->get('pagebuilder_elements')->row_array();
    return $data;
}



function listAllServices()
{
    $CI = &get_instance();
    $data = $CI->db->select('*')
        ->from('services')
        ->where('active', 1)
        ->get()->result_array();
    return $data;
}
function listAllNews()
{
    $CI = &get_instance();
    $data = $CI->db->select('*')
        ->from('news')
        ->get()->result_array();
    return $data;
}

function getModuleData($moduleConfig, $relation = '')
{
    // e($moduleConfig);
    $CI = &get_instance();
    $data = [];
    if ($relation == '') {
        $CI->db->select('*');
        $CI->db->from($moduleConfig['element_table']);
        if ($moduleConfig['element_table'] == 'slideshow_image') {
            $CI->db->where('slideshow_id', $moduleConfig['slider_id']);
        }
        if ($moduleConfig['element_table'] != 'product') {
            $CI->db->where('active', 1);
        }
        if ($moduleConfig['element_table'] == 'services') {
            $CI->db->order_by('sort_order', 'ASC');
        }
        if ($moduleConfig['element_table'] == 'category') {
            $CI->db->where('active', 1);
            $CI->db->where_in('id', $moduleConfig['moduledata']);
        }
        if ($moduleConfig['element_table'] == 'projects') {
            $CI->db->where_in('projects_id', $moduleConfig['moduledata']);
        }
        if ($moduleConfig['element_table'] == 'product') {
            $CI->db->where('is_active', 1);
            $CI->db->where_in('id', $moduleConfig['moduledata']);
        }

        $data = $CI->db->get()->result_array();
    } else {
        $relations = $CI->db->select('*')
            ->from($relation)
            ->where('active', 1)
            ->get()->result_array();
        $sub_items = [];
        if ($relations) {
            foreach ($relations as $row) {
                $query = $CI->db->where('portfolio_category', $row['id'])->where('active', 1)->get($moduleConfig['element_table'])->result_array();
                $sub_items[$row['id']] = $row;
                $sub_items[$row['id']]['sub_items'] = $query;
            }
            $data = $sub_items;
        }
    }
    // e($data);
    return $data;
}


function getModuleDatacategory($moduleConfig)
{
    // e($moduleConfig);
    $CI = &get_instance();
    $data = [];
    foreach ($moduleConfig['moduledata'] as $item) {
        $CI->db->select('*');
        $CI->db->from($moduleConfig['element_table']);
        $CI->db->where('active', 1);
        $CI->db->where('id', $item);
        $result = $CI->db->get()->row_array();
        array_push($data, $result);
    }
    return $data;
}


function createMyCss()
{
    $CI = &get_instance();
    $content = "";
    $webStyles = [];
    $tabStyle = [];
    $mobileStyles = [];
    // $cssFilePath = str_replace('admin\\', '', FCPATH) . "css/my_theme.css";
    $cssFilePath = str_replace('admin/', '', FCPATH) . "css/my_theme.css";
    $adminCssPath = FCPATH . "css/my_theme.css";

    $allRows = $CI->db->select('*')->get('pagebuilder_page_rows')->result_array();
    $columns = $CI->db->select('id,row_id,page_id,style_config,content_config')->from('pagebuilder_columns')->get()->result_array();

    if ($columns) {
        foreach ($columns as $column) {
            $cls = '.cls_' . $column['id'] . $column['row_id'] . $column['page_id'];
            $column_style = json_decode($column['style_config'], true);
            foreach ($column_style as $column_style_key => $column_style_value) {
                if (strpos($column_style_key, 'web_') !== false) {
                    $webStyles[$cls][$column_style_key] = $column_style_value;
                }
                if (strpos($column_style_key, 'tab_') !== false) {
                    $tabStyle[$cls][$column_style_key] = $column_style_value;
                }
                if (strpos($column_style_key, 'mobile_') !== false) {
                    $mobileStyles[$cls][$column_style_key] = $column_style_value;
                }
            }
        }
    }

    if ($webStyles) {
        $content .= createStyleString($webStyles, 'web');
    }
    if ($tabStyle) {
        $content .= createStyleString($tabStyle, 'tab');
    }
    if ($mobileStyles) {
        $content .= createStyleString($mobileStyles, 'mobile');
    }

    if ($allRows) {
        foreach ($allRows as $property => $singleRow) {
            $cls = '';
            $row_style = json_decode($singleRow['style_config'], true);
            $cls = '.cls_' . $singleRow['id'] . $singleRow['page_id'];
            foreach ($row_style as $prop => $style) {
                $property = explode('_', $prop);
                $content .= "$cls{ $property[0]: $style[0]px $style[1]px $style[2]px $style[3]px; }";
            }
        }
    }

    $file = fopen($cssFilePath, "w");
    fwrite($file, $content);
    fclose($file);
    $file = fopen($adminCssPath, "w");
    fwrite($file, $content);
    fclose($file);
}

function createStyleString($styleArr, $device)
{
    $cssStr = '';
    $mediaQuery = '';

    if ($device == 'web') {
        $mediaQuery = '@media(min-width: 1200px){';
    } else if ($device == 'tab') {
        $mediaQuery = '@media(min-width:768px) and (max-width: 1199px){';
    } else if ($device == 'mobile') {
        $mediaQuery = '@media(max-width: 767px){';
    }

    $cssStr .= $mediaQuery;
    foreach ($styleArr as $selector => $webStyle) {
        $cssStr .= $selector . '{';
        foreach ($webStyle as $prop => $val) {
            $unit = '';
            $prop_arr = explode('_', $prop);
            if (count($prop_arr) == 3) {
                $unit = $prop_arr[2];
            }
            $cssStr .= $prop_arr[1] . ':' . $val . $unit . ';';
        }
        $cssStr .= '}';
    }
    $cssStr .= '}';
    return $cssStr;
}

function createDefaultCss()
{
    $CI = &get_instance();
    $content = "";
    $fonts = [];
    // $cssFilePath = str_replace('admin\\', '', FCPATH) . "css/default_theme.css";
    $cssFilePath = str_replace('admin/', '', FCPATH) . "css/default_theme.css";

    $elements = $CI->db->select('*')->get('design_config')->result_array();
    foreach ($elements as $element) {
        $element_css = json_decode($element['config_json'], true);
        $selector = $element['element_class'] != '' ? '.' . $element['element_class'] : $element['element'];
        $content .= $selector . '{';
        foreach ($element_css as $prop => $value) {
            if ($prop == 'font-family') {
                $tmp = [];
                $tmp['element'] = $selector;
                $tmp['font'] = $value;
                $fonts[] = $tmp;
            } else {
                $content .= $prop . ":" . $value . ";";
            }
        }
        $content .= '}';
    }

    if ($fonts) {
        foreach ($fonts as $font) {
            $font_face = explode('_fam_', $font['font']);
            $font_src = $font_face[0];
            $font_family = $font_face[1];
            $content .= '@font-face {';
            $content .= '   font-family: "' . $font_family . '";';
            $content .= '   src: url("' . $font_src . '");';
            $content .= '}';

            $content .= $font['element'] . '{';
            $content .= '   font-family: ' . $font_family;
            $content .= '}';
        }
    }

    $file = fopen($cssFilePath, "w");
    fwrite($file, $content);
    fclose($file);
}
function getMainImage($id)
{
    $CI = &get_instance();
    $data = $CI->db->select('*')
        ->where('projects_id', $id)
        ->from('projects_img')
        ->get()->row_array();
    return $data;
}
function getsitecolor()
{
    $CI = &get_instance();
    $data = $CI->db->select('*')
        ->where('element', 'site-color')
        ->from('design_config')
        ->get()->row_array();
    return $data;
}

function listAllProjects()
{
    $CI = &get_instance();

    $CI->db->where('active', '1');
    $query = $CI->db->get('projecttype');
    $results =  $query->result_array();

    $project_data = [];
    foreach ($results as $key => $item) {
        $CI->db->select('*');
        $CI->db->from('projects');
        $CI->db->where('project_cat', $item['id']);
        $project = $CI->db->get()->result_array();
        if ($project) {
            $project_data[$key] =  $item;
            $project_data[$key]['project'] = $project;
        }
    }

    return $project_data;
}
function listAllPageTemplates()
{
    $CI = &get_instance();
    $query = $CI->db->get('pagebuilder_templates');
    $results =  $query->result_array();

    return $results;
}

function getAllProduct()
{
    $CI = &get_instance();
    $query = $CI->db->where('is_active', 1)->get('product');
    $results =  $query->result_array();

    return $results;
}

function getNewArrivalsSelectedProduct($selectProductArray)
{
    $CI = &get_instance();
    $product_data = [];
    foreach ($selectProductArray['productdata'] as $key => $item) {
        $CI->db->select('*');
        $CI->db->from('product');
        $CI->db->where('id', $item);
        $product = $CI->db->get()->row_array();
        if ($product) {
            $product_data[$key] = $product;
        }
    }
    return $product_data;
}
function getproductMainImage($id)
{
    $CI = &get_instance();
    $data = $CI->db->select('*')
        ->where('pid', $id)
        ->from('prod_img')
        ->get()->row_array();
    return $data;
}

function getData($table, $column = null, $value = null)
{
    if ($column != null) : if (is_array($column)) : $data = getThis()->db->get_where($table, $column);
        else : $data = getThis()->db->get_where($table, array($column => $value));
        endif;
    else : $data = getThis()->db->get($table);
    endif;
    if ($data->num_rows() > 0) : return $data->row_array();
    endif;
    return false;
}

function getDataArray($table, $column = null, $value = null)
{
    if ($column != null) : if (is_array($column)) : $data = getThis()->db->get_where($table, $column);
        else : $data = getThis()->db->get_where($table, array($column => $value));
        endif;
    else : $data = getThis()->db->get($table);
    endif;
    if ($data->num_rows() > 0) : return $data->result_array();
    endif;
    return false;
}
/* End of file com_helper.php */
/* Location: ./system/helpers/number_helper.php */
