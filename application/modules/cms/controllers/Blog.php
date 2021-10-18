<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog extends Cms_Controller {
    
   
  function productByAjax($offset = 0){
//      e($offset);
        $this->load->model('Pagemodel');
        $this->load->model('blog/Blogmodel');
        $this->load->library('pagination');
        $page=$this->input->post("page");       
        $perpage=$this->input->post("perPage");

//        e($perpage);
        if(!empty($page) && !empty($perpage)){
//            e(444);
            $count=$this->Blogmodel->countAll();;
//        $perpage = 2;
//            $offset = (($page - 1) * $perpage);
        $config['base_url'] = base_url() . "blog/index";
        $config['uri_segment'] = 5;
        $config['total_rows'] = $count;
        $config['per_page'] = $perpage;

//        $choice = $config["total_rows"] / $config["per_page"];
//        $config["num_links"] = floor($choice);
        $config['full_tag_open'] = "<ul class='pagination pagi-ul'  style='margin:auto;display:table'>";
        $config['full_tag_close'] = "</ul >";
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev ajax-page">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'next';
        $config['next_tag_open'] = '<li class="ajax-page">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active ajax-page"><a class="page-link disabled" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="ajax-page">';
        $config['num_tag_close'] = '</li>';
//        e($config);
        $this->pagination->initialize($config);
        $blog = $this->Blogmodel->listAllBlog($offset, $perpage);
        $recent_blog = $this->Blogmodel->recentblog();
        $inner = array();
        $inner['blog'] = $blog;
        $blog_view='';
                    foreach ($blog as $value) { 
                        $date = strtotime($value['blog_date']);
                                $date = date('d-M-Y', $date);
                                $date = explode('-', $date);
//                    e($blog);
                                 if (!$value['blog_image']) {
                            $imageP = "images/default_product_image.jpg";
                        } else {
                            $imageP = $this->config->item('BLOG_THUMBNAIL_PATH') . $value['blog_image'];
                        }
                                $blog_view .= '<ul>'
                                        . '<li>'
                                        . '<div class="blog-img-rel">'
                                        . ' <img src="'. resize($imageP, 90, 90, 'blog_image').'" alt="'.$value['blog_title'].'"class="img-responsive" />'
                                        . '<div class="blog-trangle"></div>'
                                        . '</div>'
                                        . '</li>'
                                        . '<li>'
                                        . '<p class="p1">'.$value['blog_title'].'</p>'
                                        . '<p class="p2">'.$date[0].' '.$date[1].','.' '.$date[2].'</p>'
                                        . '<span class="p3">'.word_limiter($value['blog_contents'], 20).'<a href="blog/details/'.$value['blog_alias'].'">Read More</a></span> '
                                        . '</li>'
                                        . '</ul>';

                    }
            $out = array();
//            $out['success'] = 1;
            $out['html'] = $blog_view;
            if ($count > $perpage) {
            if (!empty($blog)) {
                $out['count'] = 1;
            } else {
                $out['count'] = 0;
            }
            } else {
                $out['count'] = 0;
            }
            $out['page'] = $page;
            $out['count'] = $count;
            $out['pagination']=$this->pagination->create_links();
            echo json_encode($out);
            exit;
        }
    }
}
?>