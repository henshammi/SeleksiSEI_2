<?php
class Proyek_model extends CI_Model {
    private $api_url = 'http://localhost:8080/proyek';

    public function get_all_proyek() {
        $response = file_get_contents($this->api_url);
        return json_decode($response, true);
    }

    public function get_proyek_by_id($id) {
        $url = $this->api_url . '/' . $id;
        $response = file_get_contents($url);
        return json_decode($response, true);
    }

    public function create_proyek($data) {
        $options = array(
            'http' => array(
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ),
        );
        $context  = stream_context_create($options);
        return file_get_contents($this->api_url, false, $context);
    }

    public function update_proyek($id, $data) {
        $url = $this->api_url . '/' . $id;
        $options = array(
            'http' => array(
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'PUT',
                'content' => json_encode($data),
            ),
        );
        $context  = stream_context_create($options);
        return file_get_contents($url, false, $context);
    }

    public function delete_proyek($id) {
        $url = $this->api_url . '/' . $id;
        $options = array(
            'http' => array(
                'method'  => 'DELETE',
            ),
        );
        $context  = stream_context_create($options);
        return file_get_contents($url, false, $context);
    }
}
