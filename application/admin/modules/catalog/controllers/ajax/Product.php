<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function upload() {
        if ($_FILES['file']['name'] != "") {
            $config = array();
            $config['upload_path'] = $this->config->item('PRODUCT_PATH') . 'temp';
            $config['allowed_types'] = '*';
            $config['overwrite'] = TRUE;
            $this->load->library('upload', $config);
            if (count($_FILES) > 0) {
                if ($_FILES['file']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['file']['tmp_name'])) {
                    $this->upload->do_upload('file');
                }
            }
        }
    }

    function delete() {
        $path = $this->config->item('PRODUCT_PATH') . 'temp';
        $filename = $path . $_POST['fileList'];
        if (file_exists($filename)) {
            @unlink($filename);
        }
    }

    function getAttrOption($attrid) {
        return $this->db
                        ->from('attribute_option')
                        ->where('attr_id', intval($attrid))
                        ->get()
                        ->result_array();
    }

//    function getAttrOptionData($attrid, $pid) {
//        return $this->db
//                        ->from('attribute_option')
//                        ->where('attr_id', intval($attrid))
//                        ->get()
//                        ->result_array();
//    }

    function getAttrOptionData($attrid, $pid) {
        $re = $this->db
                ->select('value')
                ->from('attribute_varchar')
                ->where('attr_id', $attrid)
                ->where('pid', $pid)
                ->get()
                ->row();
        return isset($re->value) ? $re->value : false;
    }

    function getAttrTextData($attrid, $pid) {
        $re = $this->db
                ->select('text')
                ->from('attribute_text')
                ->where('attr_id', $attrid)
                ->where('pid', $pid)
                ->get()
                ->row();

        return $re->text;
    }

    function getattr_by_atrid($aid, $pid = 0) {
//        $this->load->model('Categorymodel');
//        $attrset = $this->Categorymodel->catattrsetid($cid);
//        e($aid);
        $output = array();
        $this->db->from('attribute t1');
        $this->db->join('attr_attrset t2', 't1.id=t2.attr_id', 'left');
        $this->db->where('t2.set_id', intval($aid));
        $rs = $this->db->get();
        $rs = $rs->result_array();
        $data = array();
        foreach ($rs as $r) {
            if (($r['type'] == 'dropdown') || ($r['type'] == 'radio') || ($r['type'] == 'varchar')) {
                $r[$r['type']] = self::getAttrOption($r['attr_id']);
                if ($pid != 0) {
                    $r['data'] = self::getAttrOptionData($r['attr_id'], $pid);
                }
            }
            if ($r['type'] == 'text') {
                $r[$r['type']] = self::getAttrOption($r['attr_id']);
                if ($pid != 0) {
                    $r['data'] = self::getAttrTextData($r['attr_id'], $pid);
                }
            }
            $data[] = $r;
        }
        echo json_encode($data);
    }

    function getcatattr($cid, $pid = 0) {
        $this->load->model('Categorymodel');
        $attrset = $this->Categorymodel->catattrsetid($cid);
//        e($attrset,0);
        //print_r(json_encode($attrset));
        $output = array();
        $this->db->from('attribute t1');
        $this->db->join('attr_attrset t2', 't1.id=t2.attr_id', 'left');
        $this->db->where('t2.set_id', intval($attrset['attrset_id']));
        $rs = $this->db->get();
        $rs = $rs->result_array();
        $data = array();
        foreach ($rs as $r) {
            if (($r['type'] == 'dropdown') || ($r['type'] == 'radio') || ($r['type'] == 'varchar')) {
                $r[$r['type']] = self::getAttrOption($r['attr_id']);
                if ($pid != 0) {
                    $r['data'] = self::getAttrOptionData($r['attr_id'], $pid);
                }
            }
            if ($r['type'] == 'text') {
                $r[$r['type']] = self::getAttrOption($r['attr_id']);
                if ($pid != 0) {
                    $r['data'] = self::getAttrTextData($r['attr_id'], $pid);
                }
            }
            $data[] = $r;
        }
        echo json_encode($data);
    }

    function gxetcatattr($cid) {

        $attrset = catattrsetid($cid);
//        $this->db->select('attrset_id')->where('id', $cid)->get('category')->row();
        $output = array();
        $this->db->from('attribute t1');
        $this->db->join('attr_attrset t2', 't1.id=t2.attr_id', 'left');
        $this->db->where('t2.set_id', intval($attrset->id));
        $rs = $this->db->get();
        $rs = $rs->result_array();
        $data = array();
        foreach ($rs as $r) {
            if ($r['type'] == 'dropdown' || $r['type'] == 'radio') {
                $this->db->from('attribute_option');
                $this->db->where('attr_id', intval($r['attr_id']));
                $ar = $this->db->get();
                $r[$r['type']] = $ar->result_array();
            }
            $data[] = $r;
        }
        echo json_encode($data);
    }

    function catProduct() {
        $this->load->model('productmodel');
        $type = $this->input->post('type', TRUE);
        $catId = $this->input->post('catId', TRUE); //this changed in attribute id
        $pid = $this->input->post('PID', TRUE) ? $this->input->post('PID', TRUE) : 0;
        // $catId = 60;
        // $pid   = 164;

        $selAttributes = array();
        $selAttributes['attributes'] = array();

        if (!empty($pid)) {
            $selAttributes = $this->productmodel->selectAttributes($pid);
            //print_r(json_encode($selAttributes));
            //exit();
        }


        //print_r($selAttributes);

        $data = array();
        $status1 = 0;
        $status2 = 0;
        //Category Lists
        $cateAttrList = '';
        $result = array();

        $this->db->select('a2.id, a2.label, a2.name,t3.is_main, t3.custom_name');
        $this->db->from('attr_attrset a1');
//        $this->db->join('attr_attrset a1', 'a1.set_id = c1.attrset_id');
        $this->db->join('attribute a2', 'a2.id = a1.attr_id');
        $this->db->join('product_configurable_attr t3', "t3.attr_id = a2.id AND t3.parent_id = $pid", 'left');
//        $this->db->where('c1.id', intval($catId));
        $this->db->where('a1.set_id', intval($catId));
        $this->db->group_by('a2.id');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $status1 = 1;
            $result = $query->result_array();

            //e($result);
            $cateAttrList = '<div class="panel panel-default">';
            $cateAttrList .= '<div class="panel-body">';
            // $cateAttrList .= ' <div class="col-xs-12 nn-style-sec-bg-col">
            // <div class="col-xs-1">sec</div>
            // <div class="col-xs-4">Attribute</div>
            // <div class="col-xs-4">Attribute name</div>
            // <div class="col-xs-1">Assignment</div>
            // <div class="col-xs-1">In main</div>
            
            
            // </div>
            
            // <div class="col-xs-12">
            // <div class="col-xs-1">1</div>
            // <div class="col-xs-4">Fabric</div>
            // <div class="col-xs-4"><input type="text"></div>
            // <div class="col-xs-1"><input type="checkbox"></div>
            // <div class="col-xs-1"><input type="radio"></div>
            // </div>';
            // $cateAttrList .= '<div class="col-lg-8">';
            $cateAttrList .= '<div class="col-lg-12">';
            $i = 1;
            foreach ($result as $atritem) {
                $checked_str = $hidden_str = "";
                if ($atritem['is_main'] == 1)
                    $checked_str = 'checked="checked"';
                // if(!in_array($atritem['is_main'],["0",1]))
                //   $hidden_str = 'hidden';

                $cateAttrList .= '<div class="col-lg-12">
                                        <div class="row">
                                          <div class="col-lg-9">
                                         
                                            <div class="col-lg-8">
                                            <label>' . $i . ' ' . $atritem['label'] . '</label>
                                            <br/>
                                            <input name="attributesListName[' . $atritem['id'] . ']" value="' . $atritem['custom_name'] . '" />
                                            </div>
                                            <div class="col-lg-4">
                                                <input class="att-chkbx att-chkbx-a" type="checkbox" label="' . $atritem['label'] . '" name="attributesList[]" ';
                if (!empty($selAttributes['attributes'])) {
                    if (in_array($atritem['id'], $selAttributes['attributes'])) {
                        // if($selAttributes['cid'] == $catId){
                        $cateAttrList .= 'checked="checked" ';
                        // }
                    }
                }
                $cateAttrList .= '  value="' . $atritem['id'] . '">
                                            </div>
                                          </div>
                            <div class="col-lg-3 ' . $hidden_str . '">
                                <div class="col-lg-8">
                                   <label>Is Main</label>
                                </div>
                                <div class="col-lg-4">
                                   <input class="att-chkbx" type="radio" label="is main" ' . $checked_str . ' name="is_main_attribute" value=' . $atritem['id'] . '>
                                </div>
                            </div>
                        </div>
                    </div>';
                // $cateAttrList .= "
                // <div class='col-lg-6'>
                //     <div class='col-lg-8'>
                //        <label>Is Main</label>
                //     </div>
                //     <div class='col-lg-4'>
                //        <input class='att-chkbx' type='radio' label='is main' name='is_main' value='".$atritem['id']."'>
                //     </div>
                // </div>
                // ";
                $i++;
            }

            $cateAttrList .= '</div></div></div>';
        }
        // echo $cateAttrList;
        // exit;
        $data['status1'] = $status1;
        $data['catAttributes'] = $cateAttrList;

        //Product Lists
        /*
          $proDucts = '';
          $this->db->select('t1.id as pid, t1.name,t1.sku, GROUP_CONCAT(a2.id) as attr_id, GROUP_CONCAT(a2.label) as attr_label, t1.price, t1.quantity');
          $this->db->from('product t1');
          $this->db->join('cat_prod t2', 't2.pid = t1.id');
          $this->db->join('attribute_varchar a1', 'a1.pid = t1.id');
          $this->db->join('attribute a2', 'a2.id = a1.attr_id');
          $this->db->where('t2.cid', intval($catId));
          $this->db->where('t1.type', 'standard');
          $this->db->where('t1.is_active', 1);
          $this->db->group_by('t1.id');
          $rs = $this->db->get();
          if ($rs->num_rows() > 0) {
          $status2 = 1;
          $rs = $rs->result_array();
          $proDucts = '<div class="panel panel-default">';
          $proDucts .= '<div class="panel-body">';
          $proDucts .= '<div class="col-lg-12">';
          $proDucts .= '<table id="example" cellpadding="0" cellspacing="0" border="0" width="100%" class="table table-striped table-bordered">';
          $proDucts .= '<thead><tr>';
          $proDucts .= '<th>SKU</th>';
          $proDucts .= '<th>Name</th>';
          $proDucts .= '<th>Assigned Attributes</th>';
          $proDucts .= '<th>Price</th>';
          $proDucts .= '<th>Stock</th>';
          $proDucts .= '<th>Assign</th>';
          $proDucts .= '</tr>';
          $proDucts .= '<tr id="filterrow">';
          $proDucts .= '<th>SKU</th>';
          $proDucts .= '<th>Name</th>';
          $proDucts .= '<th>Assigned Attributes</th>';
          $proDucts .= '<th>Price</th>';
          $proDucts .= '<th>Stock</th>';
          $proDucts .= '<th>Assign</th></tr>';
          $proDucts .= '</thead><tbody>';

          $i = 1;
          foreach ($rs as $item) {
          $proDucts .= "<tr id='rowC-".$item['pid']."' class='childProd' data-obj='".json_encode($item)."'>";
          $proDucts .= '<td>' . $item['sku'] . '</td>';
          $proDucts .= '<td>' . $item['name'] . '</td>';
          $proDucts .= '<td>' . $item['attr_label'].'</td>';
          //$proDucts .= '<td>' . $item['attr_label'] . '<input type="hidden" label="' . $item['name'] . '" name="checkAttribute'.$i.'" value="' . $item['attr_id'] . '"></td>';
          $proDucts .= '<td>' . $item['price'] . '</td>';
          $proDucts .= '<td>' . $item['quantity'] . '</td>';
          $proDucts .= '<td class="assign-btn"><button data-label="'. $item['name'] . '" data-value="'. $item['attr_id'].'" id="assign_product'.$i.'" class="btn btn-primary" type="button" onclick="checkAttribute(this)" >Add</button></td>';

          $proDucts .= '</tr>';
          $i++;
          }
          $proDucts .= '</tbody></table>';
          $proDucts .= '</div></div></div>';
          }
         */


        $data['status2'] = $status2;
        $data['product'] = '';


        echo json_encode($data);
    }

    function childProducts($cid, $productId) {
        $this->load->model('product_allocation/assignmodel');
        $this->load->model('productmodel');
        // $cid = 1;
        $search = $this->input->post('search');
        $searchTerm = $search['value'];
        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $attrbs = $this->input->post('attrbs');

        // $limit = 10;
        // $productId = 4897;
        $childPids = $this->productmodel->ProductChild($productId, $attrbs);        
        $childProds = $this->productmodel->childProductsAllTemp($childPids, $attrbs);
        $data = $this->assignmodel->childProductsAll($cid, $limit, $offset, $searchTerm, $productId, $attrbs, $childPids, $childProds);
//        e($data);
//        echo json_encode($data);
        $sortedData = array();
        foreach ($data['data'] as $dat) {
            if (in_array($dat['id'], $childPids)) {
                $dat['is_checked'] = 1;
            } else {
                $dat['is_checked'] = 0;
            }
            $sortedData[] = $dat;
        }

        function cmp($a, $b) {
            if ($a[is_checked] == $b[is_checked]) {
                return 0;
            }
            return ($a[is_checked] > $b[is_checked]) ? -1 : 1;
        }

        usort($sortedData, "cmp");
//        e($sortedData);
        $sortedData['data'] = $sortedData;
        $sortedData['recordsFiltered'] = $data['recordsFiltered'];
        $sortedData['recordsTotal'] = $data['recordsTotal'];
        echo json_encode($sortedData);
    }

    function non_config_products() {
        $this->load->model('Productmodel');
        //header('Content-Type: application/json');
        $search = $this->input->post('search');
        $searchTerm = $search['value'];
        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $data = $this->Productmodel->get_non_config_products_dt($limit, $offset, $searchTerm);
        echo json_encode($data);
        die;
    }

}

?>
