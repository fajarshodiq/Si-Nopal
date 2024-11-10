<?php

namespace App\Models;

use CodeIgniter\Model;

class PerkaraModel extends Model
{
    protected $table = 't_perkara'; // Nama tabel
    protected $primaryKey = 'id_perkara'; // Primary key

    protected $allowedFields = [
        'no_perkara',
        'no_whatsapp',
        'email',
        'nama_penggugat',
        'nama_tergugat',
        'alamat',
        'tanggal_pendaftaran'
    ];

    // Tidak menggunakan timestamps
    protected $useTimestamps = false;

    // Mengambil perkara berdasarkan id
    public function getPerkaraById(int $id_perkara): ?array
    {
        return $this->where('id_perkara', $id_perkara)->first();
    }

    // Mengambil semua perkara
    public function getAllPerkara(): array
    {
        return $this->findAll();
    }

    // Menghitung jumlah perkara
    public function countPerkara(): int
    {
        return $this->countAll();
    }

    // Mengambil perkara berdasarkan kondisi tertentu
    public function getPerkaraByCondition(array $conditions): array
    {
        return $this->where($conditions)->findAll();
    }

    // Memperbarui perkara berdasarkan id
    public function updatePerkara(int $id_perkara, array $data): bool
    {
        return $this->update($id_perkara, $data);
    }

    // Menghapus perkara berdasarkan id
    public function deletePerkara(int $id_perkara): bool
    {
        return $this->delete($id_perkara);
    }
}
