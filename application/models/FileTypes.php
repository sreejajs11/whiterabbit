<?php

class FileTypes extends CI_Model {

    public $id;
    public $name;
    
    public function get() {
        return $this->db->get('file_types')->result();
    }
}
