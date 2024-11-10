<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id'; // Sesuaikan dengan primary key tabel Anda
    protected $allowedFields = ['username', 'nama', 'password']; // Tambahkan field lain jika perlu

    // Menambahkan fitur untuk menghindari pengulangan username
    protected $validationRules = [
        'username' => 'required|is_unique[users.username,id,{id}]', // Pastikan username unik
        'nama' => 'required',
        'password' => 'required|min_length[6]', // Pastikan password minimal 6 karakter
    ];

    public function getUserById($id)
    {
        return $this->find($id);
    }

    public function updateUser($id, $data)
    {
        // Pastikan untuk memvalidasi data sebelum memperbarui
        if ($this->validate($data)) {
            return $this->update($id, $data);
        } else {
            return false; // Kembalikan false jika validasi gagal
        }
    }
}
