<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Api_model');
        $this->load->model('Ds_model');
    }

    public function index() {

    }
    
    public function nytimesoverview(){
         $data = array(
            'dataquery' => $this->input->post('dataquery'),    
            'dsID' => $this->input->post('dsID')
        );
//        var_dump($_POST);
//        exit;
        
        $k = $this->Ds_model->get_key_by_id($this->input->post('dsID'));
        $http1 = 'https://api.nytimes.com/svc/books/v3/lists/overview.json?published_date='.$this->input->post('dataquery');
        
        $url = $http1.'&api-key='.$k;
        $xmlData = file_get_contents($url);
        $manage = json_decode($xmlData, true);
        $data['data'] = $manage; 
        
        
        
        $this->load->view('nytimesoverview_view1', $data);
    }
    
    public function metodo($metodoID, $dsID) {
        
//        var_dump($info_method['http']);
//        exit;
        
        $k = $this->Ds_model->get_key_by_id($dsID);
        $http = $this->Ds_model->get_key_by_id($dsID);
        //$http1 = parse_url($http);
        $http1 = 'https://api.nytimes.com/svc/books/v3/lists/names.json';

        
        if($metodoID == 1 and $dsID == 5){ 
            //$metodoID == 1 and $dsID ==5 is for implementation of Best Seller list names
            $url = $http1.'?api-key='.$k;
            $xmlData = file_get_contents($url);
            $manage = json_decode($xmlData, true);
            $data['data'] = $manage; 
            $this->load->view('method_view', $data);
            
        }elseif($metodoID == 6 and $dsID == 5){  
            //$metodoID == 6 and $dsID ==5 is for implementation of Get top 5 books for all Best Sellers list
            $data['id'] = $dsID; 
            $this->load->view('nytimesoverview_view', $data); //view to get the date for the query 
            
        }else {   //redirect to the begin because a new method nees to be implemented 
             $data['sources'] = $this->Ds_model->get_all_ds();
             $this->load->view('ds_view', $data);
        }
    }
    
    public function api_add() {
        $data = array(
            'desc' => $this->input->post('desc'),    
            'http' => $this->input->post('http'),
            'dsID' => $this->input->post('dsID')
        );
        $insert = $this->Api_model->api_add($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_edit($id) {
        $data = $this->Api_model->get_by_id($id);
        echo json_encode($data);
    }

    public function api_update() {
        $data = array(
            'methodID' => $this->input->post('methodID'),
            'desc' => $this->input->post('desc'),
            'http' => $this->input->post('http'),
            'dsID' => $this->input->post('dsID'),
        );
        $this->Api_model->api_update(array('methodID' => $this->input->post('methodID')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ds_delete($id) {
        $this->Api_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
