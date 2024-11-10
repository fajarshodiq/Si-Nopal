<?php

namespace App\Controllers;

use App\Models\PerkaraModel;

class Perkara extends BaseController
{
    protected $perkaraModel;

    public function __construct()
    {
        $this->perkaraModel = new PerkaraModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Daftar Perkara', // Definisikan $title
            'perkara' => $this->perkaraModel->findAll()
        ];

        return view('perkara/index', $data);
    }


    public function create()
    {
        return view('perkara/create');
    }

    public function save()
    {
        $this->perkaraModel->save([
            'no_perkara' => $this->request->getVar('no_perkara'),
            'nama_penggugat' => $this->request->getVar('nama_penggugat'),
            'nama_tergugat' => $this->request->getVar('nama_tergugat'),
            'tanggal_pendaftaran' => $this->request->getVar('tanggal_pendaftaran'),
            'alamat' => $this->request->getVar('alamat'),
            'email' => $this->request->getVar('email'),
            'no_whatsapp' => $this->request->getVar('no_whatsapp'),
        ]);

        return redirect()->to('/perkara');
    }

    public function edit($no_perkara)
    {
        $data['perkara'] = $this->perkaraModel->find($no_perkara);
        return view('perkara/edit', $data);
    }

    public function update()
    {
        $no_perkara = $this->request->getVar('no_perkara');
        $this->perkaraModel->update($no_perkara, [
            'nama_penggugat' => $this->request->getVar('nama_penggugat'),
            'nama_tergugat' => $this->request->getVar('nama_tergugat'),
            'tanggal_pendaftaran' => $this->request->getVar('tanggal_pendaftaran'),
            'alamat' => $this->request->getVar('alamat'),
            'email' => $this->request->getVar('email'),
            'no_whatsapp' => $this->request->getVar('no_whatsapp'),
        ]);

        return redirect()->to('/perkara');
    }

    public function delete($no_perkara)
    {
        $this->perkaraModel->delete($no_perkara);
        return redirect()->to('/perkara');
    }
}
