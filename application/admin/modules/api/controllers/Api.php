<?php

header("Access-Control-Allow-Origin: *");

require APPPATH . 'libraries/REST_Controller.php';



class Api extends REST_Controller
{



    public function __construct()
    {

        parent::__construct();

        $this->load->database();
    }


    public function index_get($id = 0)

    {

        if (!empty($id)) {

            $data = $this->db->get_where("user", ['user_id' => $id])->row_array();
        } else {

            $data = $this->db->get("user")->result();
        }



        $this->response($data, REST_Controller::HTTP_OK);
    }



    public function index_post()

    {
        $input = json_decode(trim(file_get_contents('php://input')), true);
        $this->db->set($input);
        $this->db->insert('user', $input);


        echo json_encode([
            'success' => true,
            'msg' => 'data inserted'
        ]);
        // $this->response(['Item created successfully.'], REST_Controller::HTTP_OK);

    }



    public function index_put($id)

    {

        $input = $this->put();

        $this->db->update('user', $input, array('id' => $id));



        $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
    }



    public function index_delete($id)

    {

        $this->db->delete('user', array('id' => $id));



        $this->response(['Item deleted successfully.'], REST_Controller::HTTP_OK);
    }
}
