<?php

namespace App\Models;

use CodeIgniter\Model;

class AktaCeraiModel extends Model
{
    protected $table = 't_akta_cerai';
    protected $primaryKey = 'id_akta_cerai';
    protected $allowedFields = ['id_perkara', 'no_seri', 'no_akta_cerai', 'tanggal_terbit'];

    public function getReminderData($reminderDays)
    {
        // Ambil nilai penerbitan_akta_cerai dari tabel settings
        $settingsModel = new \App\Models\SettingModel();
        $settings = $settingsModel->find(1); // Asumsi id settings adalah 1
        $penerbitanAktaCerai = (int)$settings['penerbitan_akta_cerai']; // Pastikan ini adalah integer

        // Hitung tanggal pengingat berdasarkan hari
        $reminderDate = date('Y-m-d', strtotime("+$reminderDays days"));

        // Ambil data akta cerai yang memerlukan pengingat
        $builder = $this->db->table('t_perkara');
        $builder->select('t_perkara.no_perkara, t_perkara.nama_penggugat, t_perkara.no_whatsapp, t_perkara.tanggal_pendaftaran');
        $builder->join('t_akta_cerai', 't_perkara.id_perkara = t_akta_cerai.id_perkara', 'left');

        // Ganti angka 15 dengan $penerbitanAktaCerai
        $builder->where('DATE_ADD(t_perkara.tanggal_pendaftaran, INTERVAL ' . $penerbitanAktaCerai . ' DAY)', $reminderDate);
        $builder->where('(t_akta_cerai.tanggal_terbit IS NULL OR t_akta_cerai.tanggal_terbit > CURDATE())');

        $query = $builder->get();
        return $query->getResultArray(); // Mengembalikan hasil dalam bentuk array
    }
}
