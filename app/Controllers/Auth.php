<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        // Cek apakah pengguna sudah login
        if (session()->get('logged_in')) {
            return redirect()->to('/admin'); // Arahkan ke admin jika sudah login
        }
        helper(['form']);
        return view('login'); // Menampilkan halaman login
    }

    public function loginAuth()
    {
        $session = session();
        $model = new UserModel();
        $username = $this->request->getVar('username');
        $password = md5($this->request->getVar('password')); // Mengenkripsi password dengan MD5

        // Cari user berdasarkan username dan password yang telah dienkripsi
        $user = $model->where('username', $username)->where('password', $password)->first();

        if ($user) {
            // Jika login berhasil, set session
            $sessionData = [
                'id'       => $user['id'],
                'username' => $user['username'],
                'nama'     => $user['nama'], // Menyimpan nama pengguna
                'logged_in' => TRUE
            ];
            $session->set($sessionData);
            return redirect()->to(base_url('admin'));
        } else {
            $session->setFlashdata('error', 'Username atau Password salah');
            return redirect()->back();
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('login'));
    }
}
