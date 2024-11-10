<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\SettingModel;

class Home extends BaseController
{
    protected $db;
    protected $settingModel;

    public function __construct()
    {
        // Inisialisasi koneksi database
        $this->db = \Config\Database::connect();
        $this->settingModel = new SettingModel();
    }

    public function index(): string
    {
        $setting = $this->settingModel->getSettings();
        $data = [
            'title' => 'Cek Akta Cerai',
            'delivery' => $setting['delivery'],
            'bg' => $setting['latar_login']
        ];
        return view('home', $data);
    }

    public function login(): string
    {
        $data = [
            'title' => 'Login - SI NOPAL 2024'
        ];
        return view('login', $data);
    }

    public function check_status()
    {
        $nopendaftaran = $this->request->getPost('nopendaftaran');

        // Lakukan query ke database untuk mendapatkan status akta cerai
        $query = $this->db->table('t_akta_cerai')
            ->join('t_perkara', 't_perkara.id_perkara = t_akta_cerai.id_perkara')
            ->where('t_perkara.no_perkara', $nopendaftaran)
            ->get();

        if ($query->getNumRows() > 0) {
            // Jika ada data, akta cerai sudah terbit
            return $this->response->setJSON(['status' => 'sudah_terbit']);
        } else {
            // Cek jika no_perkara ada di t_perkara
            $queryPerkara = $this->db->table('t_perkara')
                ->where('no_perkara', $nopendaftaran)
                ->get();

            if ($queryPerkara->getNumRows() > 0) {
                // Jika ada data, akta cerai belum terbit
                return $this->response->setJSON(['status' => 'belum_terbit']);
            } else {
                // Jika tidak ada data
                return $this->response->setJSON(['status' => 'tidak_terdaftar']);
            }
        }
    }

    public function validate_akta_cerai()
    {
        // Ambil input dari form
        $no_perkara = $this->request->getPost('no_perkara');
        $no_akta_cerai = $this->request->getPost('no_akta_cerai');
        $no_seri = $this->request->getPost('no_seri');

        // Lakukan query untuk memvalidasi data akta cerai
        $query = $this->db->table('t_akta_cerai')
            ->join('t_perkara', 't_perkara.id_perkara = t_akta_cerai.id_perkara')
            ->where('t_perkara.no_perkara', $no_perkara)
            ->where('t_akta_cerai.no_akta_cerai', $no_akta_cerai)
            ->where('t_akta_cerai.no_seri', $no_seri)
            ->get();

        if ($query->getNumRows() > 0) {
            // Jika data valid
            return $this->response->setJSON([
                'status' => 'valid',
                'message' => 'Data Akta Cerai Valid'
            ]);
        } else {
            // Jika data tidak valid
            return $this->response->setJSON([
                'status' => 'invalid',
                'message' => 'Data Akta Cerai Tidak Valid'
            ]);
        }
    }




    public function validasi_view(): string
    {
        $setting = $this->settingModel->getSettings();
        $data = [
            'title' => 'Validasi Akta Cerai',
            'delivery' => $setting['delivery'],
            'bg' => $setting['latar_login']
        ];
        return view('validasi', $data);
    }
}
