<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'latar_login',
        'wa_gateway',
        'wa_sender',
        'apikey',
        'penerbitan_akta_cerai',
        'delivery',
        'notifikasi_reminder',
        'notifikasi_penerbitan_akta_cerai'
    ];

    // Metode untuk mengambil data setting tunggal
    public function getSettings()
    {
        return $this->first(); // Mengambil data pertama karena biasanya hanya ada satu konfigurasi setting
    }

    // Metode untuk menyimpan atau memperbarui data setting
    public function saveSettings($data)
    {
        if ($this->countAll() > 0) {
            return $this->update(1, $data); // Mengupdate data pertama
        } else {
            return $this->insert($data); // Jika belum ada data, masukkan data baru
        }
    }
}
