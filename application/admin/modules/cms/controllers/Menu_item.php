<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu_item extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function index($mid = '', $offset = 0) {
        $this->load->model('Menulinkmodel');
        $this->load->model('Menumodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->library('pagination');

        //check resource
        if (!$this->checkAccess('MANAGE_MENU_ITEMS')) {
            $this->utility->accessDenied();
            return;
        }

        //fetch the menu details
        $menu_detail = array();
        $menu_detail = $this->Menumodel->detail($mid);
        if (!$menu_detail) {
            $this->utility->show404();
            return;
        }


        //Fetch pagetree
        $menutree = '';
        $menutree = $this->Menulinkmodel->menuItemTree(0, $menu_detail['menu_id']);

        $menu_items = array();
        $menu_items = $this->Menulinkmodel->getAll($menu_detail['menu_id']);

        //render view
        $inner = array();
        $inner['menu_detail'] = $menu_detail;
        $inner['menu_items'] = $menu_items;
        $inner['menutree'] = $menutree;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('menus/menu_items/listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add
    function add($mid = false) {
        $this->load->model('Menulinkmodel');
        $this->load->model('Menumodel');
        $this->load->model('Pagemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //check resource
        if (!$this->checkAccess('MANAGE_MENU_ITEMS')) {
            $this->utility->accessDenied();
            return;
        }

        //fetch the menu details
        $menu_detail = array();
        $menu_detail = $this->Menumodel->detail($mid);
        if (!$menu_detail) {
            $this->utility->show404();
            return;
        }

        //fetc the menu item  indentedList
        $parent_menu = array();
        $parent_menu['0'] = 'Root';
        $rs = $this->Menulinkmodel->indentedList($menu_detail['menu_id']);
        foreach ($rs as $row) {
            $parent_menu[$row['menu_item_id']] = str_repeat('&nbsp;', ($row['menu_item_level']) * 8) . $row['menu_item_name'];
        }

        //fetch the main page
        $pages = array();
        $pages[''] = 'Select';
        $rs = $this->Pagemodel->indentedActiveList(0);
        foreach ($rs as $row) {
            $pages[$row['page_id']] = str_repeat('&nbsp;', ($row['level']) * 8) . $row['title'];
        }

        //Form Validations
        $this->form_validation->set_rules('parent_id', 'Parent Name', 'trim');
        $this->form_validation->set_rules('page_id', 'Page Name', 'trim|required');
        $this->form_validation->set_rules('menu_item_name', 'Link Name', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $shell = array();

            $inner['parent_menu'] = $parent_menu;
            $inner['pages'] = $pages;
            $inner['menu_detail'] = $menu_detail;

            $shell['content'] = $this->load->view('menus/menu_items/add', $inner, TRUE);
            $this->load->view('shell', $shell);
        } else {
            $this->Menulinkmodel->insertRecord($menu_detail);

            $this->session->set_flashdata('SUCCESS', 'menu_item_added');

            redirect("cms/menu_item/index/$mid/", 'location');
            exit();
        }
    }

    //function add link
    function addurl($mid = false) {
        $this->load->model('Menulinkmodel');
        $this->load->model('Menumodel');
        $this->load->model('Pagemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //check resource
        if (!$this->checkAccess('MANAGE_MENU_ITEMS')) {
            $this->utility->acessDenied();
            return;
        }


        //fetch the menu details
        $menu_detail = array();
        $menu_detail = $this->Menumodel->detail($mid);
        if (!$menu_detail) {
            $this->utility->show404();
            return;
        }

        //fetc the menu item  indentedList
        $parent_menu = array();
        $parent_menu['0'] = 'Select-Category';
        $rs = categories();
        foreach ($rs as $row) {
            $parent_menu[$row['id']] = $row['name'];
        }
        //Form Validations
        $this->form_validation->set_rules('category_id', 'Category', 'required|callback_check_default');
        $this->form_validation->set_rules('menu_item_name', 'Link Name', 'trim|required');
        $this->form_validation->set_rules('new_window', 'New Window', 'trim');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();

            $inner['menu_detail'] = $menu_detail;
            $inner['parent_menu'] = $parent_menu;

            $page['content'] = $this->load->view('menus/menu_items/addurl', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Menulinkmodel->addlink($menu_detail);

            $this->session->set_flashdata('SUCCESS', 'menu_item_added');

            redirect("cms/menu_item/index/{$menu_detail['menu_id']}");
            exit();
        }
    }

    //function add link
    function placeholder($mid = false) {
        $this->load->model('Menulinkmodel');
        $this->load->model('Menumodel');
        $this->load->model('Pagemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //check resource
        if (!$this->checkAccess('MANAGE_MENU_ITEMS')) {
            $this->utility->acessDenied();
            return;
        }

        //fetch the menu details
        $menu_detail = array();
        $menu_detail = $this->Menumodel->detail($mid);
        if (!$menu_detail) {
            $this->utility->show404();
            return;
        }

        //fetc the menu item  indentedList
        $parent_menu = array();
        $parent_menu['0'] = 'Root';
        $rs = $this->Menulinkmodel->indentedList($menu_detail['menu_id']);
        foreach ($rs as $row) {
            $parent_menu[$row['menu_item_id']] = str_repeat('&nbsp;', ($row['menu_item_level']) * 8) . $row['menu_item_name'];
        }

        //Form Validations
        $this->form_validation->set_rules('parent_id', 'Parent Name', 'trim');
        $this->form_validation->set_rules('menu_item_name', 'Link Name', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();

            $inner['menu_detail'] = $menu_detail;
            $inner['parent_menu'] = $parent_menu;

            $page['content'] = $this->load->view('menus/menu_items/add-placeholder', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Menulinkmodel->addPlaceholder($menu_detail);

            $this->session->set_flashdata('SUCCESS', 'menu_item_added');

            redirect("cms/menu_item/index/{$menu_detail['menu_id']}");
            exit();
        }
    }

    //function edit page link
    function edit($m_item_id = false) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Menulinkmodel');
        $this->load->model('Pagemodel');

        //check resource
        if (!$this->checkAccess('MANAGE_MENU_ITEMS')) {
            $this->utility->acessDenied();
            return;
        }
        //Get Page Details
        $menu_item = array();
        $menu_item = $this->Menulinkmodel->details($m_item_id);
        if (!$menu_item) {
            $this->utility->show404();
            return;
        }
        //fetc the menu item  indentedList
        $parent_menu = array();
        $parent_menu['0'] = 'Root';
        $rs = $this->Menulinkmodel->indentedList($menu_item['menu_id'], $menu_item['menu_item_id']);
        foreach ($rs as $row) {
            $parent_menu[$row['menu_item_id']] = str_repeat('&nbsp;', ($row['menu_item_level']) * 8) . $row['menu_item_name'];
        }
        //fetch the main page
        $pages = array();
        $pages[''] = 'Select';
        $rs = $this->Pagemodel->indentedActiveList(0);
        foreach ($rs as $row) {
            $pages[$row['page_id']] = str_repeat('&nbsp;', ($row['level']) * 8) . $row['title'];
        }
        //Form Validations
        $this->form_validation->set_rules('parent_id', 'Parent Name', 'trim|required');
        $this->form_validation->set_rules('page_id', 'Page Name', 'trim|required');
        $this->form_validation->set_rules('menu_item_name', 'Link Name', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['menu_item'] = $menu_item;
            $inner['parent_menu'] = $parent_menu;
            $inner['pages'] = $pages;

            $page['content'] = $this->load->view('menus/menu_items/edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Menulinkmodel->updateLinkPageRecord($menu_item);
            $this->session->set_flashdata('SUCCESS', 'menu_item_updated');
            redirect("cms/menu_item/index/{$menu_item['menu_id']}");
            exit();
        }
    }

    //function link url
    function editurl($m_item_id) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Menulinkmodel');
        $this->load->model('Pagemodel');
        //check resource
        if (!$this->checkAccess('MANAGE_MENU_ITEMS')) {
            $this->utility->acessDenied();
            return;
        }
        //Get Page Details
        $menu_item = array();
        $menu_item = $this->Menulinkmodel->details($m_item_id);
        if (!$menu_item) {
            $this->utility->show404();
            return;
        }
        //fetc the menu item  indentedList
        $parent_menu = array();
        $parent_menu['0'] = 'Select-Category';
        $rs = categories();
        foreach ($rs as $row) {
            $parent_menu[$row['id']] = $row['name'];
        }
        //fetch the main page
        $pages = array();
        $pages[''] = 'Select';
        $rs = $this->Pagemodel->indentedActiveList(0);
        foreach ($rs as $row) {
            $pages[$row['page_id']] = str_repeat('&nbsp;', ($row['level']) * 8) . $row['title'];
        }
        //Form Validations
        $this->form_validation->set_rules('category_id', 'Category', 'required|callback_check_default');
        $this->form_validation->set_rules('menu_item_name', 'Link Name', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['menu_item'] = $menu_item;
            $inner['parent_menu'] = $parent_menu;
            $inner['pages'] = $pages;
            $page['content'] = $this->load->view('menus/menu_items/edit-url', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Menulinkmodel->updateLinkUrlRecord($menu_item);
            $this->session->set_flashdata('SUCCESS', 'menu_item_updated');
            redirect("cms/menu_item/index/{$menu_item['menu_id']}");
            exit();
        }
    }

    //function link url
    function edit_placeholder($m_item_id) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Menulinkmodel');
        $this->load->model('Pagemodel');

        //check resource
        if (!$this->checkAccess('MANAGE_MENU_ITEMS')) {
            $this->utility->acessDenied();
            return;
        }

        //Get Page Details
        $menu_item = array();
        $menu_item = $this->Menulinkmodel->details($m_item_id);
        if (!$menu_item) {
            $this->utility->show404();
            return;
        }

        $parent_menu = array();
        $parent_menu['0'] = 'Root';
        $rs = $this->Menulinkmodel->indentedList($menu_item['menu_id'], $menu_item['menu_item_id']);
        foreach ($rs as $row) {
            //$parent_menu[$row['menu_item_id']] = $row['menu_item_name'];
            $parent_menu[$row['menu_item_id']] = str_repeat('&nbsp;', ($row['menu_item_level']) * 8) . $row['menu_item_name'];
        }


        //Form Validations
        $this->form_validation->set_rules('parent_id', 'Parent Name', 'trim|required');
        $this->form_validation->set_rules('menu_item_name', 'Link Name', 'trim|required');
        ;


        $this->form_validation->set_error_delimiters('<li>', '</li>');


        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['menu_item'] = $menu_item;
            $inner['parent_menu'] = $parent_menu;

            $page['content'] = $this->load->view('menus/menu_items/edit-placeholder', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Menulinkmodel->updatePlaceholder($menu_item);

            $this->session->set_flashdata('SUCCESS', 'menu_item_updated');

            redirect("cms/menu_item/index/{$menu_item['menu_id']}/");
            exit();
        }
    }

    function delete($pid) {
        $this->load->model('Menulinkmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //check resource
        if (!$this->checkAccess('MANAGE_MENU_ITEMS')) {
            $this->utility->acessDenied();
            return;
        }

        $page_details = array();
        $page_details = $this->Menulinkmodel->details($pid);
        if (!$page_details) {
            $this->utility->show404();
            return;
        }

        $this->Menulinkmodel->deleteRecord($page_details);

        $this->session->set_flashdata('SUCCESS', 'menu_item_deleted');
        redirect("cms/menu_item/index/{$page_details['menu_id']}");
        exit();
    }

    //update the product order
    function updateorder() {
        $sortOrder = $this->input->post('debugStr', TRUE);

        if ($sortOrder) {
            $sortOrder = trim($sortOrder);
            $sortOrder = trim($sortOrder, ',');
            //file_put_contents('facelube.txt',serialize($sortOrder));
            $chunks = explode(',', $sortOrder);
            $counter = 1;
            foreach ($chunks as $id) {
                $data = array();
                $data['menu_sort_order'] = $counter;
                $this->db->where('menu_item_id', intval($id));
                $this->db->update('menu_link', $data);
                $counter++;
            }
        }
    }

    function child_categories() {
        $cat_child = $this->cat_child_have_products($this->input->get('cid'), $this->input->get('q'));
        $response = array();
        $data = array();
        if ($cat_child) {
            $response['status'] = TRUE;
            foreach ($cat_child as $child_cat) {
                $data[] = ['id' => $child_cat['id'], 'name' => $child_cat['name']];
            }
            $response['data'] = $data;
        } else {
            $response['status'] = FALSE;
            $response['data'] = '';
        }
        echo json_encode($response);
    }

    function check_default($array) {
        if ($array == 0) {
            $this->form_validation->set_message('check_default', 'Please select category');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function insert_url($mid = false) {
        $this->load->model('Menulinkmodel');
        $this->load->model('Menumodel');
        $this->load->model('Pagemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        //check resource
        if (!$this->checkAccess('MANAGE_MENU_ITEMS')) {
            $this->utility->acessDenied();
            return;
        }
        //fetch the menu details
        $menu_detail = array();
        $menu_detail = $this->Menumodel->detail($mid);
        if (!$menu_detail) {
            $this->utility->show404();
            return;
        }

        //fetc the menu item  indentedList
        $parent_menu = array();
        $parent_menu['0'] = 'Root';
        $rs = $this->Menulinkmodel->indentedList($menu_detail['menu_id']);
        foreach ($rs as $row) {
            $parent_menu[$row['menu_item_id']] = str_repeat('&nbsp;', ($row['menu_item_level']) * 8) . $row['menu_item_name'];
        }

        //Form Validations
        $this->form_validation->set_rules('parent_id', 'Parent Name', 'trim');
        $this->form_validation->set_rules('menu_item_name', 'Link Name', 'trim|required');
        $this->form_validation->set_rules('url', 'URL', 'trim|required');
        $this->form_validation->set_rules('new_window', 'New Window', 'trim');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['menu_detail'] = $menu_detail;
            $inner['parent_menu'] = $parent_menu;
            $page['content'] = $this->load->view('menus/menu_items/url_insert', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Menulinkmodel->insert_url($menu_detail);
            $this->session->set_flashdata('SUCCESS', 'menu_item_added');
            redirect("cms/menu_item/index/{$menu_detail['menu_id']}");
            exit();
        }
    }

    function update_url($m_item_id) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Menulinkmodel');
        $this->load->model('Pagemodel');

        //check resource
        if (!$this->checkAccess('MANAGE_MENU_ITEMS')) {
            $this->utility->acessDenied();
            return;
        }

        //Get Page Details
        $menu_item = array();
        $menu_item = $this->Menulinkmodel->details($m_item_id);
        if (!$menu_item) {
            $this->utility->show404();
            return;
        }

        $parent_menu['0'] = 'Root';
        $rs = $this->Menulinkmodel->indentedList($menu_item['menu_id'], $menu_item['menu_item_id']);
        foreach ($rs as $row) {
            $parent_menu[$row['menu_item_id']] = str_repeat('&nbsp;', ($row['menu_item_level']) * 8) . $row['menu_item_name'];
        }
        //Form Validations
        $this->form_validation->set_rules('parent_id', 'Parent Name', 'trim');
        $this->form_validation->set_rules('menu_item_name', 'Link Name', 'trim|required');
        $this->form_validation->set_rules('url', 'URL', 'trim|required');
        $this->form_validation->set_rules('new_window', 'New Window', 'trim');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['menu_item'] = $menu_item;
            $inner['parent_menu'] = $parent_menu;
            $page['content'] = $this->load->view('menus/menu_items/update_url', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Menulinkmodel->update_url($menu_item);
            $this->session->set_flashdata('SUCCESS', 'menu_item_updated');
            redirect("cms/menu_item/index/{$menu_item['menu_id']}/");
            exit();
        }
    }

    function cat_child_have_products($cid, $keyword) {
        return $this->db->select('t1.id,t1.name,t1.uri')
                        ->from('category t1')
                        // ->join('cat_prod t2', 't1.id=t2.cid')
                        ->where('parent_id', $cid)
                        ->like('t1.name', $keyword)
                        // ->group_by('t2.cid')
                        ->get()->result_array();
    }

}

?>