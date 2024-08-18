<?php
class Lokasi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Lokasi_model');
    }

    public function index() {
        $data['lokasi'] = $this->Lokasi_model->get_all_lokasi();
        $this->load->view('lokasi/index', $data);
    }

    public function create() {
        $this->load->view('lokasi/create');
    }

    public function store() {
        $input_data = array(
            'nama_lokasi' => $this->input->post('nama_lokasi'),
            'alamat' => $this->input->post('alamat')
        );
        $this->Lokasi_model->create_lokasi($input_data);
        redirect('lokasi');
    }

    public function edit($id) {
        $data['lokasi'] = $this->Lokasi_model->get_lokasi_by_id($id);
        $this->load->view('lokasi/edit', $data);
    }

    public function update($id) {
        $input_data = array(
            'nama_lokasi' => $this->input->post('nama_lokasi'),
            'alamat' => $this->input->post('alamat')
        );
        $this->Lokasi_model->update_lokasi($id, $input_data);
        redirect('lokasi');
    }

    public function delete($id) {
        $this->Lokasi_model->delete_lokasi($id);
        redirect('lokasi');
    }
}
