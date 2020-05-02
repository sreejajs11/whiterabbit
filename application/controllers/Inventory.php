<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper('url');

        // Load session
        $this->load->library('session');

        // Load Pagination library
        $this->load->library('pagination');

        // Load model
        $this->load->model('files');
        $this->load->model('fileTypes');
    }

    public function index() {
        redirect('Inventory/listFiles');
    }

    public function listFiles($rowno = 0) {
        // Search text
        $search_text = "";
        if ($this->input->post('submit') != NULL) {
            $search_text = $this->input->post('search');
            $this->session->set_userdata(array("search" => $search_text));
        } elseif ($this->input->post('cancel') != NULL) {
            $search_text = '';
            $this->session->set_userdata(array("search" => ''));
        } else {
            if ($this->session->userdata('search') != NULL) {
                $search_text = $this->session->userdata('search');
            }
        }

        // Row per page
        $rowperpage = 5;

        // Row position
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }

        // All records count
        $allcount = $this->files->getDataCount($search_text);

        // Get records
        $filesList = $this->files->getData($rowno, $rowperpage, $search_text);

        // Pagination Configuration
        $config['base_url'] = base_url() . 'index.php/inventory/listFiles';
        $config['use_page_numbers'] = true;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;

        // Initialize
        $this->pagination->initialize($config);

        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $filesList;
        $data['row'] = $rowno;
        $data['search'] = $search_text;

        $data['title_page'] = 'Files List';
        $data['success'] = $this->session->flashdata('success');

        $this->template->load('layout', 'index', $data);
    }

    public function upload() {

        $this->template->load('layout', 'upload', ['title_page' => 'Upload', 'fileTypes' => $this->__getAllowedTypes(), 'error' => $this->session->flashdata('error')]);
        //$this->load->view('upload');
    }

    public function upload_action() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = implode('|', $this->__getAllowedTypes());
        $config['max_size'] = '2048';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file_name')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('inventory/upload');
        } else {
            $this->files->insert_entry($this->upload->data()['file_name']);
            $this->session->set_flashdata('success', 'File successfully uploaded');
            redirect('inventory/listFiles');
        }
    }

    private function __getAllowedTypes() {
        $this->load->model('fileTypes');
        $fileTypes = [];
        $allowedTypes = $this->fileTypes->get();
        if (!empty($allowedTypes)) {
            foreach ($allowedTypes as $allowedType) {
                $fileTypes[] = $allowedType->name;
            }
        }
        return $fileTypes;
    }

}
