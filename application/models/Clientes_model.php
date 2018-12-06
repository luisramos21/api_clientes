<?php

/**
 * Description of clientes_model
 *
 * @author Luis Ramos
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes_model extends CI_Model {

    private $table = 'clients'; //name of table
    private $tableCities = 'cities';
    public $ColumnIndex = 'id'; //name of primary key of the table 
    public $columns = array(
        array(
            'name' => 'id',
            'label' => 'Identificador cliente'
        ),
        array(
            'name' => 'created',
            'label' => 'Creado',
        ),
        array(
            'name' => 'name',
            'label' => 'Nombres',
            'mensaje' => 'Escribe una Nombre.',
            'required' => 'required'
        ),
        array(
            'name' => 'last_name',
            'label' => 'Apellidos',
            'mensaje' => 'Escribe al menos un Apellido.',
            'required' => 'required'
        )
        ,
        array(
            'name' => 'type_document',
            'label' => 'Tipo de Documento',
            'mensaje' => 'Tipo de documento no válido.',
            'required' => 'required'
        ),
        array(
            'name' => 'document',
            'label' => 'Documento',
            'mensaje' => 'documento no válido.',
            'required' => 'required'
        ),
        array(
            'name' => 'email',
            'label' => 'Email',
            'mensaje' => 'Escribe un email válido.',
            'required' => 'required'
        ),
        array(
            'name' => 'city',
            'label' => 'Ciudad'
        ),
        array(
            'name' => 'address',
            'label' => 'Direccion',
            'mensaje' => 'Escribe al menos una dirección.',
            'required' => 'required'
        ),
        array(
            'name' => 'movile',
            'label' => 'Celular',
            'placeholder' => 'Escribe un celular válido.',
            'required' => 'required'
        ),
        array(
            'name' => 'phone',
            'label' => 'Teléfono',
            'placeholder' => 'Escribe un Teléfono válido.',
            'required' => 'required'
        ),
        array(
            'name' => 'state',
            'label' => 'Estado Cliente',
        ),
        array(
            'name' => 'last_update',
            'label' => 'Ultima actualización',
        )
    );

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /*
      traer datos de la bd
     *  */

    function get($id = 0, $one_record = false,$edit=false) {
        $json = array();
        $where = array("{$this->table}.state" => 1);
		$extra = ",{$this->tableCities}.city";
		if($edit){
			$extra = ",{$this->tableCities}.id";
		}
        if ($id > 0) {
            $where = array();
            $where["{$this->table}.{$this->ColumnIndex}"] = $id;
        }
        $this->db->join($this->tableCities, "{$this->tableCities}.id = {$this->table}.city");
        $this->db->where($where);
        $this->db->select("$this->table.*{$extra}");
        $data = $this->db->get($this->table);

        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {
                $json[] = (array) $row;
                if ($one_record) {
                    $json = (array) $row;
                    break;
                }
            }
        }
        return $json;
    }

    function last_clients() {
        $date = date("Y-m-d H:i:s", strtotime("-59 minutes"));
        $json = array();
        $where = "{$this->table}.created >= '{$date}'";
        
        $this->db->join($this->tableCities, "{$this->tableCities}.id = {$this->table}.city");
        $this->db->where($where);
        $this->db->select("$this->table.*,{$this->tableCities}.city");
        $data = $this->db->get($this->table);

        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {
                $json[] = (array) $row;
            }
        }
        return $json;
    }

    function getCities() {
        $json = array();

        $this->db->select("$this->tableCities.*");
        $data = $this->db->get($this->tableCities);

        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {
                $json[] = (array) $row;
            }
        }
        return $json;
    }

    function getClientsCities() {
        $json = array();
        $this->db->join($this->tableCities, "{$this->tableCities}.id = {$this->table}.city");
        $this->db->group_by("{$this->table}.city");
        $this->db->select("$this->tableCities.city as Ciudad,COUNT({$this->table}.city) as TOTAL");
        $data = $this->db->get($this->table);

        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {
                $json[] = (array) $row;
            }
        }
        return $json;
    }

    /* buscar y guardar en la propiedad column */

    function set($id) {
        $data = $this->get($id, true);
        if (!empty($data) && count($data) == 1) {
            foreach ($this->columns as $keyColum => $column) {
                foreach ($data[0] as $key => $value) {
                    if ($column['name'] == $key) {
                        $this->columns[$keyColum]['value'] = $value;
                    }
                }
            }
            return true;
        }
        return false;
    }

    function setData($data = array()) {
        $jsonData = $data;
        if (!empty($data)) {
            foreach ($this->columns as $keyColum => $column) {
                foreach ($data as $key => $value) {
                    if (isset($value['name']) && $column['name'] == $value['name'] && isset($value['value'])) {
                        $jsonData[$keyColum] = $value['value'];
                    }
                }
            }
        }
        return $jsonData;
    }

    /*
      metodo es para guardar o actualizar los datos del los monitores
     */

    function save($data = array()) {
        $update = false;

        if (isset($data['update']) && $data['update'] && isset($data[$this->ColumnIndex])) {
            $update = true;
            $this->db->where($this->ColumnIndex, $data[$this->ColumnIndex]);
            unset($data[$this->ColumnIndex]);
            unset($data['update']);
        }

        if (!$update) {
            return $this->db->insert($this->table, $data);
        } else {
            return $this->db->update($this->table, $data);
        }
    }

    /*
      metodo es para eliminar los datos del los monitores
     */

    function delete($id = 0) {
        if ($id <= 0) {
            return false;
        }
        $data['state'] = 0;
        $this->db->where($this->ColumnIndex, $id);
        return $this->db->update($this->table, $data);
    }

}

?>