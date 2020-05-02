<?php

class Files extends CI_Model {

    public $id;
    public $file_name;
    public $file_type;

    public function getData($rowno, $rowperpage, $search = "") {
        $this->db->select('*');
        $this->db->from('files');

        if ($search != '') {
            if (stristr($search, '*.')) {
                $search = str_replace('*.', '.', $search);
            }
            $this->db->like('file_name', $search);
        }

        $this->db->limit($rowperpage, $rowno);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getDataCount($search = '') {
        $this->db->select('count(id) as allcount');
        $this->db->from('files');

        if ($search != '') {
            if (stristr($search, '*.')) {
                $search = str_replace('*.', '.', $search);
            }
            $this->db->like('file_name', $search);
        }

        $query = $this->db->get();
        $result = $query->result_array();

        return $result[0]['allcount'];
    }

    public function insert_entry($fileName) {
        $this->file_name = $fileName;
        $fileNameParts = explode('.', $fileName);
        $type = end($fileNameParts);
        $this->file_type = $this->search($type)[0]->id;

        $this->db->insert('files', $this);
    }

    public function update_entry() {
        $this->file_name = $_POST['file_name'];
        $this->file_type = $_POST['file_type'];
        $this->is_deleted = $_POST['is_deleted'];
        $this->created_date = time();

        $this->db->update('files', $this, array('id' => $_POST['id']));
    }

    public function search($search) {
        $this->db->select('id');
        $this->db->from('file_types');
        $this->db->like('name', $search);
        $query = $this->db->get();
        return $query->result();
    }

}
