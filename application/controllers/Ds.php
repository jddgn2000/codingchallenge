<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ds extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Ds_model');
        $this->load->model('Api_model');
    }

    public function index() {
        $data['sources'] = $this->Ds_model->get_all_ds();
        $this->load->view('ds_view', $data);
    }
    
    public function setup($id) {
//        var_dump($id);
//        exit;
        $data['dsID'] = $id;
        
        $data['methods'] = $this->Api_model->get_all_by_dsID($id);
        $this->load->view('api_view', $data);
    }
    
    
    public function ds_add() {
        $data = array(
            'source' => $this->input->post('source'),    
            'url' => $this->input->post('url'),
            'key1' => $this->input->post('key1')
        );
        $insert = $this->Ds_model->ds_add($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_edit($id) {
        $data = $this->Ds_model->get_by_id($id);
        echo json_encode($data);
    }

    public function ds_update() {
        $data = array(
            'dsID' => $this->input->post('dsID'),
            'source' => $this->input->post('source'),
            'url' => $this->input->post('url'),
            'key1' => $this->input->post('key1')
        );
        $this->Ds_model->ds_update(array('dsID' => $this->input->post('dsID')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ds_delete($id) {
        $this->Ds_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
