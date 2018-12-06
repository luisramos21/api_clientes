<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Clientes
 *
 * @author Luis Ramos
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("America/Bogota");
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'session'));
        $this->load->model('clientes_model');
    }

    /* index funtion todos los Clientes */

    public function index() {
        $request = $this->input->post();
        if (empty($request)) {

            $clientes = $this->clientes_model->get(0, false);
            echo json_encode($clientes);
            if (empty($clientes)) {
//                ob_clean();
//                echo 'No hay Clientes.';
            }
        } else {
            // echo "Datos Cliente<br>";
            // print_r($request);
//            echo "<br>Datos No válidos";
            echo json_encode(array());
        }
//        $this->load->view('defaut');
//        $this->load->view('monitores/index', array('data' => $data));
//        $this->load->view('footer');
    }

    public function get($id) {
        $request = $this->input->get();
        $cliente = $this->clientes_model->get($id, true,isset($request['is_edit']));
        echo json_encode($cliente);
        /* test */
        if (empty($cliente)) {
            ob_clean();
            //echo "No se encontró el cliente #$id";
        }
    } 
    
    public function last_clients() {
        // echo "Clientes view";
        $cliente = $this->clientes_model->last_clients();
        echo json_encode($cliente);        
    } 
    
    public function cities() {
        $cliente = $this->clientes_model->getCities();
        echo json_encode($cliente);
    }
     public function citiesClients() {
        $clientes_cities = $this->clientes_model->getClientsCities();
        echo json_encode($clientes_cities);
    }
    
    
    public function save() {
//        echo "Clientes save";
        $request = $this->input->post();
        if (!empty($request)) {
            $request = $this->clientes_model->setData($request);

            if (isset($request['id']) && $request['id'] == 0) {
                $request['id'] = null;
                $request['created'] = date("Y-m-d H:i:s");
            } else if (isset($request['id']) && $request['id'] > 0) {
                $request['update'] = true;
                $request['last_update'] = date("Y-m-d H:i:s");
            }
            $request['state'] = 1;
            $status = $this->clientes_model->save($request);
            //echo `Estado : $status`;
            echo json_encode(array("status" => $status));
        } else {
//            echo `No hay datos para Guardar del cliente`;
            echo json_encode(array("status" => 500));
        }
    }

    function remove() {
//        echo "Clientes Remove";
        $request = $this->input->post();
        if (!empty($request['id'])) {
            $status = $this->clientes_model->delete($request['id']);
            //echo `Estado : $status`;
            echo json_encode(array("status" => $status));
        } else {
            //echo `No hay datos para borrar del cliente`;
            echo json_encode(array("status" => 500));
        }
    }

}

?>