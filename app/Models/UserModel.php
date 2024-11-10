<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id'; // Sesuaikan dengan primary key tabel Anda
    protected $allowedFields = ['username', 'nama', 'password']; // Tambahkan field lain jika perlu

    public function getUserById($id)
    {
        return $this->find($id);
    }
}
