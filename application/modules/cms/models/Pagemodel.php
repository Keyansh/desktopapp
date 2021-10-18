<?php

class Pagemodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getPageData($page, $page_setting)
    {
        $this->db->where('page_id', $page['page_id']);
        $this->db->where('page_setting', $page_setting);
        $rs = $this->db->get('page_data');
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return false;
    }

    public function breadcrumbs($pid)
    {
        //echo "here"
        $this->db->where('page_id', $pid);
        $rs = $this->db->get('page');
        $page = $rs->row_array();
        $level = $page['level'] + 1;
        $sql = "SELECT ";
        for ($i = 1; $i <= $level; $i++) {
            $sql .= "p$i.title as page$i, p$i.page_uri as page_uri$i,";
        }
        $sql = rtrim($sql, ',');
        $sql .= " FROM " . $this->db->dbprefix . "page AS p1 ";
        for ($i = 1; $i < $level; $i++) {
            $j = $i + 1;
            $sql .= " LEFT OUTER JOIN " . $this->db->dbprefix . "page AS p$j ON p$i.page_id = p$j.parent_id ";
        }
        $sql .= " WHERE p$level.page_id=$pid";

        $rs = $this->db->query($sql);
        //echo $sql;
        $row = $rs->row_array();

        $crumbs = array();
        $chunks = array_chunk($row, 2);
        foreach ($chunks as $chunk) {
            $crumbs[] = '<a href="' . $chunk[1] . '">' . $chunk[0] . '</a>';
        }

        return $crumbs;
    }

    //get all languages
    public function getAllLanguages($page, $lang)
    {
        $this->db->join('language', 'language.language_code = page.language_code');
        $this->db->where('page_uri', $page['page_uri']);
        $this->db->where('page.language_code !=', $lang);
        $this->db->order_by('language', 'ASC');
        $rs = $this->db->get('page');

        return $rs->result_array();
    }

    //function get page details
    public function getDetails($alias, $lang = 'en')
    {
        $this->db->from('page');
        $this->db->join('page_template', 'page_template.page_template_id = page.page_template_id');
        $this->db->where('page_uri', $alias);
        $this->db->where('language_code', $lang);
        $this->db->where('active', 1);
        $rs = $this->db->get();
        if ($rs->num_rows() != 1) {
            return false;
            if ($lang != 'en') {
                $this->db->from('page');
                $this->db->where('page_uri', $alias);
                $this->db->where('language_code', 'en');
                $this->db->where('active', 1);
                $rs = $this->db->get();
                if ($rs->num_rows() != 1) {
                    return false;
                }
            } else {
                return false;
            }
        }

        $page = $rs->row_array();

        return $page;
    }

    public function getDetailsForPreview($alias, $lang = 'en')
    {
        $this->db->from('page');
        $this->db->join('page_type', 'page_type.page_type_id = page.page_type_id ');
        $this->db->join('page_template', 'page_template.template_id = page.template_id ');
        $this->db->where('page_uri', $alias);
        $this->db->where('language_code', $lang);
        $this->db->where('active', 1);
        $rs = $this->db->get();
        if ($rs->num_rows() != 1) {
            return false;
            if ($lang != 'en') {
                $this->db->from('page');
                $this->db->where('page_uri', $alias);
                $this->db->where('language_code', 'en');
                $this->db->where('active', 1);
                $rs = $this->db->get();
                if ($rs->num_rows() != 1) {
                    return false;
                }
            } else {
                return false;
            }
        }

        $page = $rs->row_array();
        return $page;
    }

    public function getPageModuleSettings($page, $module_name)
    {
        $this->db->where('page_id', $page['page_id']);
        $this->db->where('module_name', $module_name);

        $rs = $this->db->get('page_data');
        if ($rs && $rs->num_rows() > 0) {
            $module = new stdClass;
            $module->module_name = $module_name;
            foreach ($rs->result_array() as $row) {
                $module->{$row['page_setting']} = $row['page_setting_value'];
            }
            return $module;
        }
        return false;
    }

    public function listAll()
    {
        $rs = $this->db->get('page');

        return $rs->result_array();
    }

    public function getMainBlock($page_id)
    {
        //print_r($page_id); exit();
        $this->db->where('page_id', $page_id);
        $this->db->where('is_main', 1);
        $rs = $this->db->get('page_block');

        return $rs->row_array();
    }

    public function getPageBlocks($page_id)
    {
        $this->db->from('page_block');
        $this->db->join('page_block_template', 'page_block_template.block_template_id = page_block.block_template_id', 'left');
        $this->db->order_by('block_sort_order', 'ASC');
        $this->db->where('page_id', $page_id);
        $this->db->where('is_active', 1);
        $rs = $this->db->get();
        return $rs->result_array();
    }

    public function getChildPages($page)
    {
        $sub_pages = array();
        $this->db->order_by('sort_order', 'ASC');
        $this->db->where('parent_id', intval($page['page_id']));
        $rs = $this->db->get('page');
        if ($rs->num_rows() > 0) {
            $sub_pages = $rs->result_array();
        } else {
            if ($page['parent_id'] > 0) {
                $this->db->order_by('sort_order', 'ASC');
                $this->db->where('parent_id', $page['parent_id']);
                $rs = $this->db->get('page');
                $sub_pages = $rs->result_array();
            }
        }
        return $sub_pages;
    }

    //    function getGlobalBlocks($page_id = 0) {
    //            $this->db->where('page_id', $page_id);
    //            $rs = $this->db->get('block');
    //            return $rs->result_array();
    //        }

    public function compiledBlocks($page)
    {
        $output = array();

        //Page Blocks
        $blocks = $this->getPageBlocks($page['page_id']);

        foreach ($blocks as $block) {
            $block['block_image_url'] = $this->config->item('BLOCK_IMAGE_URL') . $block['block_image'];
            $block['block_image_path'] = $this->config->item('BLOCK_IMAGE_PATH') . $block['block_image'];

            $compiled_tpl = $this->load->view($this->compileBlockTemplate($block), $block, true);
            $output[$block['block_alias']] = $compiled_tpl;
        }
        return $output;
    }

    public function compileBlockTemplate($block)
    {
        $CI = &get_instance();

        //No template, use default
        if (!$block['block_template_contents']) {
            return "themes/" . THEME . "/blocks/default";
        }

        $filename = "{$block['page_block_id']}.php";
        $filepath = APPPATH . "views/themes/" . THEME . "/compiled/blocks/$filename";
        $mtime = 1;
        if (file_exists($filepath)) {
            $mtime = filemtime($filepath);
        }

        //$mtime = $block['update_time'];
        //Template exists in cache, return cache
        if (file_exists($filepath) && $mtime >= $block['updated_on']) {
            return "themes/" . THEME . "/compiled/blocks/$filename";
        }

        //Store template in cache
        file_put_contents($filepath, $block['block_template_contents']);

        return "themes/" . THEME . "/compiled/blocks/$filename";
    }

    public function compiledPage($page, $inner = array())
    {
        //Fetch template details
        $this->db->where('template_id', $page['template_id']);
        $rs = $this->db->get('template');
        if ($rs->num_rows() != 1) {
            return false;
        }

        $row = $rs->row_array();
        $tpl = $row['template_contents'];

        $compiled_tpl = $this->compileTemplate($tpl, $inner);

        return $compiled_tpl;
    }

    public function compileTemplate($tpl, $data = false)
    {
        if ($data) {
            extract($data);
        }
        ob_start();
        echo eval('?>' . preg_replace("/;*\s*\?>/", "; ?>", str_replace('<?=', '<?php echo ', $tpl)));
        $buffer = ob_get_contents();
        @ob_end_clean();
        return $buffer;
    }

    public function ulList($parent, $output = '')
    {
        $this->db->where('parent_id', $parent);
        $this->db->where('active', 1);
        $this->db->join('page_block', 'page.page_id = page_block.page_id');
        $this->db->where('show_in_menu', 1);
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('page');
        if ($query->num_rows() > 0) {
            if ($parent == 0) {
                $output .= '<ul class="sf-menu">' . "\r\n";
                //$output .= '<li rel="0">'."\r\n";
            } else {
                $output .= "<ul>\r\n";
            }
            foreach ($query->result_array() as $row) {
                if ($row['page_type'] == 'Link') {
                    $output .= '<li rel="' . $row['page_id'] . '"><a href="' . $row['block_contents'] . '">' . $row['menu_title'] . "</a>\r\n";
                } else {
                    $output .= '<li rel="' . $row['page_id'] . '"><a href="' . base_url() . $row['page_alias'] . '.html">' . $row['menu_title'] . "</a>\r\n";
                    $output = $this->ulList($row['page_id'], $output);
                    $output .= "</li>\r\n";
                }
            }
            $output .= "</ul>\r\n";
        }
        return $output;
    }

    public function compiledBlocks1($page_id)
    {
        $output = array();
        $blocks = $this->getPageBlocks($page_id);
        foreach ($blocks as $block) {
            $block['block_image_url'] = $this->config->item('BLOCK_IMAGE_URL') . $block['block_image'];
            $block['block_image_path'] = $this->config->item('BLOCK_IMAGE_PATH') . $block['block_image'];
            $compiled_tpl = $this->load->view($this->compileBlockTemplate($block), $block, true);
            $output[$block['block_alias']]['content'] = $compiled_tpl;
            $output[$block['block_alias']]['type'] = $block['block_type_id'];
        }
        return $output;
    }

    public function listAllSlides()
    {
        $rs = $this->db->where('active', 1)
            ->order_by('sort_order', 'ASC')
            ->get('slideshow_image');

        if ($rs->num_rows()) {
            return $rs->result_array();
        }

        return false;
    }

    public function getGlobalBlocks($page_id = 0)
    {
        $this->db->where('page_id', $page_id);
        $rs = $this->db->get('block');
        $blocks = $rs->result_array();
        $output = array();
        foreach ($blocks as $block) {
            $block['block_image_url'] = $this->config->item('BLOCK_IMAGE_URL') . $block['block_image'];
            $block['block_image_path'] = $this->config->item('BLOCK_IMAGE_PATH') . $block['block_image'];

            $compiled_tpl = $this->load->view($this->compileBlockTemplate1($block), $block, true);
            $output[$block['block_alias']] = $compiled_tpl;
        }
        return $output;
    }

    public function compileBlockTemplate1($block)
    {
        $CI = &get_instance();

        //No template, use default
        if (!$block['block_template']) {
            return "themes/" . THEME . "/blocks/default";
        }

        $filename = "global_{$block['block_id']}.php";
        $filepath = APPPATH . "views/themes/" . THEME . "/compiled/blocks/$filename";
        //        e($filepath);
        $mtime = 1;
        if (file_exists($filepath)) {
            $mtime = filemtime($filepath);
        }

        //$mtime = $block['update_time'];
        //Template exists in cache, return cache
        if (file_exists($filepath) && $mtime >= $block['updated_on']) {
            return "themes/" . THEME . "/compiled/blocks/$filename";
        }

        //e($block);
        $imgPath = '';
        if ($block['block_image']) {
            $imgPath = $this->config->item('BLOCK_IMAGE_URL') . $block['block_image'];
        }
        $alt = $block['alt'];
        $title = $block['block_title'];
        $content = $block['block_contents'];
        $link = $block['link'];

        $block_template = $block['block_template'];

        $block_template = str_replace('{IMGSOURCE}', $imgPath, $block_template);
        $block_template = str_replace('{IMGALT}', $alt, $block_template);
        $block_template = str_replace('{TITLE}', $title, $block_template);
        $block_template = str_replace('{CONTENT}', $content, $block_template);
        $block_template = str_replace('{LINK}', $link, $block_template);

        //Store template in cache
        file_put_contents($filepath, $block_template);

        return "themes/" . THEME . "/compiled/blocks/$filename";
    }

    public function featuredProduct()
    {
        $user_id = $this->session->userdata('CUSTOMER_ID');
        if ($user_id) {
            $this->db->select('distinct t1.id, t1.name,t1.sku,t1.uri,t1.price,t1.is_new,t2.*,t1.type, t1.inc_or_exl_tax, t1.quantity, t3.discount, t3.special_price,t1.srp_price,t1.description,t1.id as pro_id,t1.is_offer_discount,t1.id as product_id', false);
        } else {
            $this->db->select('distinct t1.id,t1.name,t1.sku,t1.uri,t1.price,t1.is_new,t2.*,t1.type, t1.quantity, t1.inc_or_exl_tax,t1.srp_price,t1.description,t1.id as pro_id,t1.is_offer_discount,t1.id as product_id', false);
        }
        $dbprefix = $this->db->dbprefix;
        $subquery = "(select price from " . $dbprefix . "product where id in (
        select child_id from " . $dbprefix . "product_configurable_link where parent_id = t1.id
        ) order by price limit 1) as least_price";
        $this->db->select($subquery, false);

        $subwherequery = "IF(t1.type='config',(select quantity from " . $dbprefix . "product where id in (
        select child_id from " . $dbprefix . "product_configurable_link where parent_id = t1.id
        ) ORDER BY quantity DESC limit 1),t1.quantity) as heighest_qty";
        $this->db->select($subwherequery, false);

        $this->db->from('product t1');
        //$this->db->join('prod_img t2', 't1.id = t2.pid', 'left');
        $this->db->join('prod_img t2', 't1.id = t2.pid AND t2.main = 1', 'left');
        if ($user_id) {
            $this->db->join('product_assignment t3', "t3.product_id = t1.id AND t3.user_id = $user_id", 'left');
        }
        //$this->db->join('product_configurable_link as pf','pf.child_id != t1.id','INNER');
        $qu = "t1.is_featured = 1 AND t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        $this->db->where($qu);
        $this->db->where('t1.is_active = 1');
        $this->db->limit(10);
        if (DWS_SHOW_OUT_STOCK != 1) {
            $this->db->having('heighest_qty >', 0);
        }
        $rs = $this->db->get();
        //         die($this->db->last_query());
        if ($rs->num_rows() > 0) {
            return $rs->result_array();
        } else {
            return false;
        }
    }

    public function insertOfferRecord()
    {
        $data = array();
        $data['offer_id'] = $this->input->post('offer_id');
        $data['subject'] = $this->input->post('subject');
        $data['first_name'] = $this->input->post('fname');
        $data['last_name'] = $this->input->post('lname');
        $data['email'] = $this->input->post('email');
        $data['contact'] = $this->input->post('contact');
        $data['message'] = $this->input->post('message');
        $data['addedon'] = time();
        $insertRes = $this->db->insert('offer_request', $data);
        if ($insertRes) {
            $emailData = array();
            $emailData['DATE'] = date("jS F, Y");
            $emailData['BASE_URL'] = base_url();
            $emailData['FNAME'] = $data['first_name'];
            $emailData['LNAME'] = $data['last_name'];
            $emailData['EMAIL'] = $data['email'];
            $emailData['CONTACT'] = $data['contact'];
            $emailData['MESSAGE'] = $data['message'];

            $emailBody = $this->parser->parse('cms/emails/offer-email', $emailData, true);
            //            $emailContent['EMAIL_CONTENT'] = str_replace(array_keys($emailData), array_values($emailData), $emailTemplate['body_content']);
            //            $emailBody = $this->parser->parse('customer/emails/account-created', $emailContent, TRUE);
            //            e($emailBody);
            $this->email->initialize($this->config->item('EMAIL_CONFIG'));
            $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
            $this->email->to(DWS_EMAIL_ADMIN);
            $this->email->subject('Email for offer.');
            $this->email->message($emailBody);
            $status = $this->email->send();
        }

        return $insertRes;
    }

    public function listAllUsp()
    {
        $this->db->where('usp_active', 1);
        $this->db->order_by('sort_order', 'ASC');
        $rs = $this->db->get('usp');
        $query = $rs->result_array();
        return $query;
    }

    public function listAllTopCat()
    {
        $this->db->select('topcat.*,cat.uri,cat.name');
        $this->db->from('topcat');
        $this->db->join('category cat', 'cat.id = topcat.category');
        $this->db->where('topcat.active', 1);
        $this->db->order_by('sort_order', 'ASC');
        $rs = $this->db->get();
        $query = $rs->result_array();
        return $query;
    }

    public function listAllHomeCats()
    {
        $this->db->select('homecategories.*,cat.uri,cat.name');
        $this->db->from('homecategories');
        $this->db->join('category cat', 'cat.id = homecategories.category');
        $this->db->where('homecategories.parent_id', 0);
        $this->db->where('homecategories.is_active', 1);
        $this->db->order_by('sort_order', 'ASC');
        $rs = $this->db->get();
        $query = $rs->result_array();
        return $query;
    }

    public function listAllHomeChildCats()
    {
        $this->db->select('homecategories.*,cat.uri,cat.name');
        $this->db->from('homecategories');
        $this->db->join('category cat', 'cat.id = homecategories.category');
        $this->db->where('homecategories.parent_id !=', 0);
        $this->db->where('homecategories.is_active', 1);
        $this->db->order_by('sort_order', 'ASC');
        $rs = $this->db->get();
        $query = $rs->result_array();
        return $query;
    }

    public function listAllHomeOffers()
    {
        $this->db->select('t1.*,t2.alias,t2.name');
        $this->db->from('homeoffers t1');
        $this->db->join('offers t2', 't2.id = t1.offer_id');
        $this->db->where('t1.is_active', 1);
        $this->db->order_by('sort_order', 'ASC');
        $rs = $this->db->get();
        $query = $rs->result_array();
        return $query;
    }

    public function showAllHomeOffers()
    {
        $this->db->select('*');
        $this->db->from('offers');
        $this->db->where('is_active', 1);
        $this->db->order_by('id', 'DESC');
        $rs = $this->db->get();
        $query = $rs->result_array();
        return $query;
    }

    public function featured_category_icons()
    {
        $rs = $this->db->select('id, icon, name, uri')
            ->where('featured', 1)
            ->where('icon IS NOT NULL', null)
            ->where('active', 1)
            ->get('category');

        if ($rs->num_rows()) {
            return $rs->result_array();
        }

        return false;
    }

    public function new_arrivals()
    {
        $today = date('m/d/Y');

        $rs = $this->db->select('product.id, product.type, product.name as product_name, product.price, product.uri as product_uri, cat_prod.cid, prod_img.img as product_image, prod_img.imgalt as product_image_alt')
            ->from('product')
            ->where('product.is_new', 1)
            ->where('product.new_start_date <=', $today)
            ->where('product.new_end_date >=', $today)
            ->where('product.is_active', 1)
            ->where('prod_img.main', 1)
            ->join('cat_prod', 'cat_prod.pid = product.id')
            ->join('category', 'category.id = cat_prod.cid')
            ->join('prod_img', 'prod_img.pid = product.id')
            ->get();

        if ($rs->num_rows()) {
            $rs = $rs->result_array();
            $arr0 = array();

            foreach ($rs as $item) {
                if ($item['type'] == 'config') {
                    $temp = $this->db->select('child_id')
                        ->where('parent_id', $item['id'])
                        ->get('product_configurable_link');

                    if ($temp->num_rows()) {
                        array_push($arr0, $item);
                    }
                } else {
                    $temp = $this->db->select('child_id')
                        ->where('child_id', $item['id'])
                        ->get('product_configurable_link');

                    if ($temp->num_rows() == 0) {
                        array_push($arr0, $item);
                    }
                }
            }

            $result = array();

            foreach ($arr0 as $item) {
                $r = array();

                if (!isset($result[$item['cid']])) {
                    $p = $item['cid'];
                    while ($p != 0) {
                        $rs2 = array();
                        $rs2 = $this->db->select('id, parent_id, name, uri, image, image_alt')
                            ->where('id', $p)
                            ->where('parent_id !=', 0)
                            ->where('active', 1)
                            ->get('category');

                        if ($rs2->num_rows() == 1) {
                            $r = $rs2->first_row('array');
                            $p = $r['parent_id'];
                        } else {
                            break;
                        }
                    }

                    $rs2 = $this->db->select('id, parent_id, name, uri, icon')
                        ->where('id', $p)
                        ->where('active', 1)
                        ->get('category');

                    if ($rs2->num_rows() == 1) {
                        $r = $rs2->first_row('array');
                    }

                    if (!isset($result[$p])) {
                        $arr = array();
                        $arr['id'] = $r['id'];
                        $arr['name'] = $r['name'];
                        $arr['icon'] = $r['icon'];
                        $result[$p] = array();
                        $result[$p]['category'] = $arr;
                        $result[$p]['product'] = array();
                    }
                }

                $arr2 = array();
                $arr2['id'] = $item['id'];
                $arr2['name'] = $item['product_name'];
                $arr2['uri'] = $item['product_uri'];
                $arr2['price'] = $item['price'];
                $arr2['image'] = $item['product_image'];
                $arr2['alt'] = $item['product_image_alt'];

                array_push($result[$p]['product'], $arr2);
            }

            return $result;
        }

        return false;
    }

    public function homepage_categories()
    {
        $rs = $this->db->select('t1.*')
            ->from('category t1')
            // ->join('cat_prod t2', 't2.cid=t1.id')
            // ->where('t1.parent_id', 0)
            ->where('t1.active', 1)
            ->where('t1.show_in_homepage', 1)
            ->order_by("t1.id", 'asc')
            ->limit(4)
            // ->group_by('t2.cid')
            ->get()->result_array();

        return $rs;
    }

    public function trending_categories()
    {
        $result = array();
        $rs = $this->db->select('t1.id, t1.name, t1.uri,t1.image,t1.image_alt')
            ->from('category t1')
            ->join('cat_prod t2', 't2.cid=t1.id')
            ->where('t1.parent_id', 0)
            ->where('t1.active', 1)
            ->where('t1.show_in_homepage', 1)
            ->order_by("t1.id", 'asc')
            ->limit(12)
            ->group_by('t2.cid')
            ->get()->result_array();
        if ($rs) {
            foreach ($rs as $item) {
                $rs2 = $this->db->select('t1.id, t1.name, t1.uri,t1.image,t1.image_alt')
                    ->from('category t1')
                    ->join('cat_prod t2', 't2.cid=t1.id')
                    ->where('t1.parent_id', $item['id'])
                    ->where('t1.active', 1)
                    ->where('t1.show_in_homepage', 1)
                    ->order_by("t1.id", 'asc')
                    ->limit(5)
                    ->group_by('t2.cid')
                    ->get()->result_array();
                $result[$item['id']] = array();
                $result[$item['id']]['category'] = $item;
                if ($rs2) {
                    $result[$item['id']]['sub_categories'] = $rs2;
                } else {
                    $result[$item['id']]['sub_categories'] = '';
                }
            }
            return $result;
        }
        return [];
    }

    public function ad_banners()
    {
        $rs = $this->db->where('active', 1)
            ->get('ad_banner');

        if ($rs->num_rows()) {
            return $rs->result_array();
        }

        return false;
    }

    public function array_column1(array $input, $columnKey, $indexKey = null)
    {
        $array = array();
        foreach ($input as $value) {
            if (!array_key_exists($columnKey, $value)) {
                trigger_error("Key \"$columnKey\" does not exist in array");
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            } else {
                if (!array_key_exists($indexKey, $value)) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                }
                if (!is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }

    public function testimonials()
    {
        $rs = $this->db->select('*')->where('active', 1)->get('testimonial');

        if ($rs->num_rows()) {
            return $rs->result_array();
        }

        return false;
    }

    public function get_pdfs($product_id)
    {
        $rs = array();
        $rs = $this->db->select('*')
            ->where('product_id', $product_id)
            ->get('product_pdf');

        if ($rs->num_rows()) {
            return $rs->result_array();
        }

        return false;
    }

    public function price_filter($arr)
    {
        $less_than_100 = 0;
        $less_than_200 = 0;
        $less_than_300 = 0;
        $less_than_400 = 0;
        $less_than_500 = 0;
        $more_than_500 = 0;

        $result = array();

        if ($arr) {
            foreach ($arr as $k => $v) {
                if ($v < 100) {
                    $less_than_100++;
                } else if ($v >= 100 && $v < 200) {
                    $less_than_200++;
                } else if ($v >= 200 && $v < 300) {
                    $less_than_300++;
                } else if ($v >= 300 && $v < 400) {
                    $less_than_400++;
                } else if ($v >= 400 && $v < 500) {
                    $less_than_500++;
                } else {
                    $more_than_500++;
                }
            }
            $str = DWS_CURRENCY_SYMBOL . '0.00 - ' . DWS_CURRENCY_SYMBOL . '99.99';
            $result[$str] = $less_than_100;

            $str = DWS_CURRENCY_SYMBOL . '100.00 - ' . DWS_CURRENCY_SYMBOL . '199.99';
            $result[$str] = $less_than_200;

            $str = DWS_CURRENCY_SYMBOL . '200.00 - ' . DWS_CURRENCY_SYMBOL . '299.99';
            $result[$str] = $less_than_300;

            $str = DWS_CURRENCY_SYMBOL . '300.00 - ' . DWS_CURRENCY_SYMBOL . '399.99';
            $result[$str] = $less_than_400;

            $str = DWS_CURRENCY_SYMBOL . '400.00 - ' . DWS_CURRENCY_SYMBOL . '499.99';
            $result[$str] = $less_than_500;

            $str = DWS_CURRENCY_SYMBOL . '500.00 and above';
            $result[$str] = $more_than_500;

            return $result;
        }
    }

    public function attribute_filter($category_id, $attribute_set_id)
    {
        $qu = "t2.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        $result = array();
        $out = array();

        $this->db->select('attr_id');
        $this->db->from('attr_attrset');
        $this->db->where_in('set_id', $attribute_set_id);
        $rs = $this->db->get()->result_array();
        $rs = array_column($rs, 'attr_id');
        $this->db
            ->select('t4.id,t3.pid,t5.option,t5.id as option_id,IF(max(t7.quantity) > 0,max(t7.quantity),t2.quantity) as count', false)
            ->from('attribute_varchar t1')
            ->join('product t2', 't2.id  = t1.pid')
            ->join('cat_prod t3', 't3.pid = t2.id')
            ->join('attribute t4', 't4.id = t1.attr_id')
            ->join('attribute_option t5', 't5.id = t1.value')
            ->join('product_configurable_link t6', 't6.child_id = t2.id', 'left')
            ->join('br_product t7', 't7.id = t6.parent_id', 'left')
            ->where("t5.option !=", "assigned")
            ->where('t3.cid', $category_id)
            ->where("t2.is_active", 1)
            ->where($qu)
            ->group_by('t1.value')
            ->having("count >", 0)
            ->order_by("t5.option", "ASC");
        if ($rs) {
            $this->db->where_in('t4.id', $rs);
        }
        $result = $this->db->get()->result_array();
        $out = [];
        foreach ($result as $key => $options) {
            //  foreach($options as $option){
            $out[$options['id']][$options['option_id']] = $options['count'];
            //  }
        }
        return $out;
    }

    public function brand_attribute_filter($bid, $attribute_set_id)
    {
        $qu = "t2.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        $result = array();
        $out = array();

        $this->db->select('attr_id');
        $this->db->from('attr_attrset');
        $this->db->where_in('set_id', $attribute_set_id);
        $rs = $this->db->get()->result_array();
        $rs = array_column($rs, 'attr_id');
        $this->db
            ->select('t4.id,t5.option,t5.id as option_id,IF(max(t7.quantity) > 0,max(t7.quantity),t2.quantity) as count', false)
            ->from('attribute_varchar t1')
            ->join('product t2', 't2.id  = t1.pid')
            ->join('attribute t4', 't4.id = t1.attr_id')
            ->join('attribute_option t5', 't5.id = t1.value')
            ->join('product_configurable_link t6', 't6.child_id = t2.id', 'left')
            ->join('br_product t7', 't7.id = t6.parent_id', 'left')
            ->where("t5.option !=", "assigned")
            ->where('t2.bid', $bid)
            ->where("t2.is_active", 1)
            ->where($qu)
            ->group_by('t1.value')
            ->having("count >", 0)
            ->order_by("t5.option", "ASC");
        if ($rs) {
            $this->db->where_in('t4.id', $rs);
        }
        $result = $this->db->get()->result_array();
        $out = [];
        foreach ($result as $key => $options) {
            $out[$options['id']][$options['option_id']] = $options['count'];
        }
        return $out;
    }

    public function get_brand($alias)
    {
        $rs = array();
        $rs = $this->db->select('*')
            ->from('brand')
            ->where('alias', $alias)
            ->where('active', 1)
            ->get();

        if ($rs->num_rows() == 1) {
            return $rs->first_row('array');
        }

        return false;
    }

    public function brand_filter($category_id, $attribute_set_id)
    {
        $rs = array();
        $rs = $this->db->select('brand.id as id')
            ->from('brand')
            ->get();

        //define variable
        $result = $out = array();

        if ($rs->num_rows()) {
            $rs = $rs->result_array();
            $rs = array_column($rs, 'id');

            foreach ($rs as $k => $v) {
                $rs2 = array();
                $rs2 = $this->db->distinct('product.id')->select('brand.name as name, product.id as product_id')
                    ->from('attribute_varchar')
                    ->join('attribute_option', 'attribute_option.id = attribute_varchar.value')
                    ->join('cat_prod', 'cat_prod.pid = attribute_varchar.pid')
                    ->join('attribute', 'attribute.id = attribute_varchar.attr_id')
                    ->join('product', 'product.id = cat_prod.pid')
                    ->join('brand', 'brand.id = product.bid')
                    ->where('cat_prod.cid', $category_id)
                    ->where('brand.id', $v)
                    ->get();

                if ($rs2->num_rows()) {
                    $result[$v] = $rs2->result_array();
                }
            }
        }

        if ($result) {
            foreach ($result as $k => $v) {
                $out[$k] = count($v);
            }
        }
        return $out;
    }

    public function config_id($id)
    {
        $rs = array();
        $rs = $this->db->select('parent_id as id')
            ->from('product_configurable_link')
            ->where('child_id', $id)
            ->get();

        if ($rs->num_rows() == 1) {
            $r = array();
            $r = $rs->first_row('array');
            return $r['id'];
        }

        return 0;
    }

    function get_products_from_attribute_option($attribute_option)
    {
        return $this->db->select('*')
            ->from('attribute_varchar')
            ->where('value', $attribute_option['attribute_option_id'])
            ->get()->result_array();
    }

    function get_categories_from_pid($pids)
    {
        if (!$pids) {
            return [];
        }
        return $this->db->select('cid')
            ->from('cat_prod')
            ->where_in('pid', $pids)
            ->get()->result_array();
    }

    function get_categories($cids)
    {
        if (!$cids) {
            return [];
        }
        return $this->db->select('*')
            ->from('category')
            ->where_in('id', $cids)
            ->get()->result_array();
    }

    function attribute_option($id)
    {
        return $this->db->select('icon,option')
            ->from('attribute_option')
            ->where_in('id', $id['attribute_option_id'])
            ->get()->result_array();
    }

    public function all_parent_categories()
    {
        $result = $this->db->select('t1.id, t1.name, t1.uri,t1.image,t1.image_alt')
            ->from('category t1')
            ->join('cat_prod t2', 't2.cid = t1.id')
            ->where('t1.parent_id', 0)
            ->where('t1.active', 1)
            ->order_by("t1.id", 'asc')
            ->group_by('t2.cid')
            ->get()->result_array();
        return $result;
    }
    public function page_blocks($page_id)
    {
        $data = [];
        $this->db->where('page_id', $page_id);
        $this->db->where('is_publish', 1);
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('pagebuilder_page_rows');
        $blocks = $query->result_array();

        foreach ($blocks as $key => $item) {
            $this->db->where('page_id', $item['page_id']);
            $this->db->where('row_id', $item['id']);
            $this->db->order_by('id', 'ASC');
            $this->db->where('is_publish', 1);
            $query = $this->db->get('pagebuilder_columns');
            $blobkElement = $query->result_array();

            $data[$item['id']] =  $item;
            $data[$item['id']]['blockElement'] =  $blobkElement;
        }
        return $data;

        // foreach ($blocks as $block) {
        //     $block['block_image_url'] = $this->config->item('BLOCK_IMAGE_URL') . $block['block_image'];
        //     $block['block_image_path'] = $this->config->item('BLOCK_IMAGE_PATH') . $block['block_image'];
        //     $compiled_tpl = $this->load->view($this->compileBlockTemplate($block), $block, true);
        //     $output[$block['block_alias']]['content'] = $compiled_tpl;
        //     $output[$block['block_alias']]['type'] = $block['block_type_id'];
        // }
    }




    public function projectsTypes()
    {
        $this->db->where('active', 1);
        $rs = $this->db->get('projecttype');
        return $rs->result_array();
    }
}
