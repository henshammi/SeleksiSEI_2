<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proyek extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('curl');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index() {
        // URL dari REST API Spring Boot untuk proyek dan lokasi
        $api_proyek_url = 'http://localhost:8080/proyek'; // Sesuaikan dengan endpoint API proyek Anda
        $api_lokasi_url = 'http://localhost:8080/lokasi'; // Sesuaikan dengan endpoint API lokasi Anda

        // Mengambil data proyek dari API menggunakan CURL
        $response_proyek = $this->curl->simple_get($api_proyek_url);
        $data['proyek'] = json_decode($response_proyek, true);

        // Mengambil data lokasi dari API menggunakan CURL
        $response_lokasi = $this->curl->simple_get($api_lokasi_url);
        $data['lokasi'] = json_decode($response_lokasi, true);

        // Memuat view dengan data yang diambil dari API
        $this->load->view('proyek_view', $data);
    }

    public function create_lokasi() {
        // Menampilkan form input lokasi
        $this->load->view('create_lokasi_view');
    }

    public function store_lokasi() {
        $this->form_validation->set_rules('nama_lokasi', 'Nama Lokasi', 'required');
        $this->form_validation->set_rules('negara', 'Negara', 'required');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
        $this->form_validation->set_rules('kota', 'Kota', 'required');
    
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('create_lokasi_view');
        } else {
            $data = array(
                'nama_lokasi' => $this->input->post('nama_lokasi'),
                'negara' => $this->input->post('negara'),
                'provinsi' => $this->input->post('provinsi'),
                'kota' => $this->input->post('kota')
            );
    
            $api_url = 'http://localhost:8080/lokasi';
            $options = array(
                'http' => array(
                    'header'  => "Content-Type: application/json\r\n",
                    'method'  => 'POST',
                    'content' => json_encode($data),
                ),
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($api_url, false, $context);
    
            // Tambahkan logging untuk respon API
            if ($result === FALSE) {
                $error = error_get_last();
                log_message('error', 'Gagal mengirim data ke API: ' . $error['message']);
                $this->session->set_flashdata('message', 'Gagal menambahkan data lokasi');
            } else {
                log_message('info', 'Berhasil mengirim data ke API: ' . $result);
                $this->session->set_flashdata('message', 'Data lokasi berhasil ditambahkan');
            }
    
            redirect('proyek/create_lokasi');
        }
    }

    public function create_proyek() {
        // Menampilkan form input proyek
        $this->load->view('create_proyek_view');
    }

    public function store_proyek() {
        // Validasi form
        $this->form_validation->set_rules('nama_proyek', 'Nama Proyek', 'required');
        $this->form_validation->set_rules('client', 'Client', 'required');
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'required');
        $this->form_validation->set_rules('tgl_selesai', 'Tanggal Selesai', 'required');
        $this->form_validation->set_rules('pimpinan_proyek', 'Pimpinan Proyek', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

        if ($this->form_validation->run() === FALSE) {
            // Jika validasi gagal, tampilkan form kembali dengan pesan error
            $this->load->view('create_proyek_view');
        } else {
            // Data dari form
            $data = array(
                'nama_proyek' => $this->input->post('nama_proyek'),
                'client' => $this->input->post('client'),
                'tgl_mulai' => $this->input->post('tgl_mulai'),
                'tgl_selesai' => $this->input->post('tgl_selesai'),
                'pimpinan_proyek' => $this->input->post('pimpinan_proyek'),
                'keterangan' => $this->input->post('keterangan')
            );

            // Kirim data ke REST API
            $api_url = 'http://localhost:8080/proyek'; // Sesuaikan dengan endpoint API Anda
            $options = array(
                'http' => array(
                    'header'  => "Content-Type: application/json\r\n",
                    'method'  => 'POST',
                    'content' => json_encode($data),
                ),
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($api_url, false, $context);

            if ($result === FALSE) {
                $this->session->set_flashdata('message', 'Gagal menambahkan data proyek');
                $this->load->view('create_proyek_view');
            } else {
                $this->session->set_flashdata('message', 'Data proyek berhasil ditambahkan');
                redirect('proyek/create_proyek');
            }
        }
    }

    public function edit_lokasi($id) {
        $api_url = 'http://localhost:8080/lokasi/' . $id;
    
        // Inisialisasi cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Set metode GET
    
        // Eksekusi cURL
        $response = curl_exec($ch);
    
        // Cek apakah terjadi error
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            $this->session->set_flashdata('message', 'Gagal mengambil data lokasi: ' . $error_msg);
            redirect('proyek/create_lokasi');
        }
    
        // Tutup cURL
        curl_close($ch);
    
        // Decode data JSON
        $data['lokasi'] = json_decode($response, true);
    
        if ($data['lokasi'] === NULL) {
            $this->session->set_flashdata('message', 'Data lokasi tidak ditemukan');
            redirect('proyek/create_lokasi');
        }
    
        // Load view untuk edit lokasi
        $this->load->view('edit_lokasi_view', $data);
    }
    
    

    public function update_lokasi($id) {
        // Validasi form
        $this->form_validation->set_rules('nama_lokasi', 'Nama Lokasi', 'required');
        $this->form_validation->set_rules('negara', 'Negara', 'required');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
        $this->form_validation->set_rules('kota', 'Kota', 'required');
    
        if ($this->form_validation->run() === FALSE) {
            // Jika validasi gagal, tampilkan form kembali dengan pesan error
            $this->edit_lokasi($id);
        } else {
            // Data dari form
            $data = array(
                'nama_lokasi' => $this->input->post('nama_lokasi'),
                'negara' => $this->input->post('negara'),
                'provinsi' => $this->input->post('provinsi'),
                'kota' => $this->input->post('kota')
            );
    
            // Kirim data ke REST API untuk update
            $api_url = 'http://localhost:8080/lokasi/' . $id;
    
            // Inisialisasi cURL
            $ch = curl_init($api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Set metode PUT
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Data JSON untuk PUT
    
            // Eksekusi cURL
            $result = curl_exec($ch);
    
            // Cek apakah terjadi error
            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
                curl_close($ch);
                $this->session->set_flashdata('message', 'Gagal memperbarui data lokasi: ' . $error_msg);
                $this->edit_lokasi($id);
            } else {
                curl_close($ch);
                $this->session->set_flashdata('message', 'Data lokasi berhasil diperbarui');
                redirect('proyek/create_lokasi');
            }
        }
    }

    public function edit_proyek($id) {
        // Ambil data proyek dari REST API
        $api_url = 'http://localhost:8080/proyek/' . $id;
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
    
        if ($response === FALSE) {
            $this->session->set_flashdata('message', 'Gagal mengambil data proyek');
            redirect('proyek');
        }
    
        $data['proyek'] = json_decode($response, true);
        
        if ($data['proyek'] === NULL) {
            $this->session->set_flashdata('message', 'Data proyek tidak ditemukan');
            redirect('proyek');
        }
    
        // Tampilkan view edit proyek
        $this->load->view('edit_proyek_view', $data);
    }
    
    public function update_proyek($id) {
        // Validasi form
        $this->form_validation->set_rules('nama_proyek', 'Nama Proyek', 'required');
        $this->form_validation->set_rules('client', 'Client', 'required');
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'required');
        $this->form_validation->set_rules('tgl_selesai', 'Tanggal Selesai', 'required');
        $this->form_validation->set_rules('pimpinan_proyek', 'Pimpinan Proyek', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
    
        if ($this->form_validation->run() === FALSE) {
            // Jika validasi gagal, tampilkan form kembali dengan pesan error
            $this->edit_proyek($id);
        } else {
            // Data dari form
            $data = array(
                'nama_proyek' => $this->input->post('nama_proyek'),
                'client' => $this->input->post('client'),
                'tgl_mulai' => $this->input->post('tgl_mulai'),
                'tgl_selesai' => $this->input->post('tgl_selesai'),
                'pimpinan_proyek' => $this->input->post('pimpinan_proyek'),
                'keterangan' => $this->input->post('keterangan')
            );
    
            // Kirim data ke REST API untuk update
            $api_url = 'http://localhost:8080/proyek/' . $id;
            $ch = curl_init($api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Set metode PUT
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Data JSON untuk PUT
            $result = curl_exec($ch);
    
            if ($result === FALSE) {
                $error_msg = curl_error($ch);
                curl_close($ch);
                $this->session->set_flashdata('message', 'Gagal memperbarui data proyek: ' . $error_msg);
                $this->edit_proyek($id);
            } else {
                curl_close($ch);
                $this->session->set_flashdata('message', 'Data proyek berhasil diperbarui');
                redirect('proyek');
            }
        }
    }    
}
