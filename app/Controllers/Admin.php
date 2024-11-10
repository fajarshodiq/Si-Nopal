<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PerkaraModel;
use App\Models\AktaCeraiModel;
use App\Models\SettingModel;

class Admin extends Controller
{
    protected $perkaraModel;
    protected $aktaCeraiModel; // Tambahkan variabel untuk model AktaCerai
    protected $settingModel;

    public function __construct()
    {
        $this->perkaraModel = new PerkaraModel();
        $this->aktaCeraiModel = new AktaCeraiModel(); // Inisialisasi model AktaCerai
        $this->settingModel = new SettingModel();
    }

    public function index(): mixed // Ubah tipe pengembalian menjadi mixed
    {
        // Periksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/')); // Redirect ke halaman home
        }

        // Hitung jumlah akta cerai
        $aktaCeraiCount = $this->aktaCeraiModel->countAll();

        // Hitung jumlah perkara
        $perkaraCount = $this->perkaraModel->countAll();

        $data = [
            'title' => 'Si NOPAL | Dashboard',
            'jumlah_akta_cerai' => $aktaCeraiCount,
            'jumlah_perkara' => $perkaraCount
        ];

        return view('admin/pages/dashboard', $data);
    }

    public function dataPerkara(): mixed
    {
        // Periksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/')); // Redirect ke halaman home
        }

        // Join t_perkara dengan t_akta_cerai
        $this->perkaraModel->select('t_perkara.*, t_akta_cerai.id_perkara AS akta_terkait, t_akta_cerai.tanggal_terbit');
        $this->perkaraModel->join('t_akta_cerai', 't_akta_cerai.id_perkara = t_perkara.id_perkara', 'left');

        // Ambil nilai penerbitan_akta_cerai dari tabel settings
        $settingsModel = new \App\Models\SettingModel();
        $penerbitanAktaCerai = (int) $settingsModel->first()['penerbitan_akta_cerai'];

        $perkaraData = $this->perkaraModel->findAll();
        foreach ($perkaraData as &$perkara) {
            if (!$perkara['akta_terkait']) { // Jika akta cerai belum terbit
                $tanggalPendaftaran = strtotime($perkara['tanggal_pendaftaran']);
                $tanggalPenerbitan = strtotime("+{$penerbitanAktaCerai} days", $tanggalPendaftaran);
                $today = time();

                $selisihHari = ceil(($tanggalPenerbitan - $today) / 86400); // 86400 detik per hari
                if ($selisihHari > 0) {
                    $perkara['status_akta'] = [
                        'label' => 'warning',
                        'text' => "{$selisihHari} Hari Lagi"
                    ];
                } else {
                    $perkara['status_akta'] = [
                        'label' => 'danger',
                        'text' => 'Belum Terbit'
                    ];
                }
            } else {
                $perkara['status_akta'] = [
                    'label' => 'success',
                    'text' => 'Sudah Terbit'
                ];
            }
        }

        $data = [
            'title' => 'Daftar Perkara',
            'perkara' => $perkaraData
        ];

        return view('admin/pages/data_perkara', $data);
    }

    public function tambahPerkara(): mixed // Ubah tipe pengembalian menjadi mixed
    {
        // Periksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/')); // Redirect ke halaman home
        }

        // Siapkan data dari input pengguna
        $data = [
            'no_perkara' => $this->request->getPost('no_perkara'),
            'no_whatsapp' => $this->request->getPost('no_whatsapp'),
            'email' => $this->request->getPost('email'),
            'nama_penggugat' => $this->request->getPost('nama_penggugat'),
            'nama_tergugat' => $this->request->getPost('nama_tergugat'),
            'alamat' => $this->request->getPost('alamat'),
            'tanggal_pendaftaran' => $this->request->getPost('tanggal_pendaftaran')
        ];

        // Simpan data dan periksa keberhasilan
        if ($this->perkaraModel->save($data)) {
            // Data berhasil disimpan
            return redirect()->to(base_url('admin/dataperkara')); // Redirect ke halaman daftar perkara
        } else {
            // Tangani kesalahan jika penyimpanan gagal
            return redirect()->back()->with('errors', $this->perkaraModel->errors());
        }
    }

    public function updatePerkara($id_perkara): mixed
    {
        // Periksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/')); // Redirect ke halaman home jika belum login
        }

        // Validasi data yang dikirimkan
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_penggugat' => 'required',
            'nama_tergugat' => 'required',
            'tanggal_pendaftaran' => 'required|valid_date[Y-m-d]',
            'alamat' => 'permit_empty|string|max_length[255]',
            'email' => 'permit_empty|valid_email',
            'no_whatsapp' => 'permit_empty|regex_match[/^[0-9]{10,15}$/]', // Validasi nomor WhatsApp
        ]);

        // Jalankan validasi
        // if (!$validation->withRequest($this->request)->run()) {
        //     // Jika validasi gagal, kembali ke halaman edit dengan pesan error
        //     return redirect()->back()->withInput()->with('error', $validation->getErrors());
        // }

        // Ambil data dari form
        $data = [
            'nama_penggugat' => $this->request->getPost('nama_penggugat'),
            'nama_tergugat' => $this->request->getPost('nama_tergugat'),
            'tanggal_pendaftaran' => $this->request->getPost('tanggal_pendaftaran'),
            'alamat' => $this->request->getPost('alamat'),
            'email' => $this->request->getPost('email'),
            'no_whatsapp' => $this->request->getPost('no_whatsapp'),
        ];

        // Update data menggunakan id_perkara
        try {
            // Cek apakah id_perkara valid
            if (!$this->perkaraModel->find($id_perkara)) {
                return redirect()->back()->with('error', 'Data perkara tidak ditemukan.');
            }

            // Lakukan update data
            $this->perkaraModel->update($id_perkara, $data);

            // Set flashdata untuk notifikasi sukses
            return redirect()->to(base_url('admin/dataperkara'))->with('success', 'Data Perkara berhasil diperbarui.');
        } catch (\Exception $e) {
            // Set flashdata untuk notifikasi error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function deletePerkara($id_perkara): mixed // Ubah tipe pengembalian menjadi mixed
    {
        // Periksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/')); // Redirect ke halaman home
        }

        // dd($id_perkara);

        // Hapus data dari model berdasarkan id_perkara
        $this->perkaraModel->delete($id_perkara);

        // Redirect ke halaman data perkara
        return redirect()->to(base_url('/admin/dataperkara')); // Ganti dengan rute yang sesuai
    }

    public function dataAktaCerai(): mixed
    {
        // Periksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/')); // Redirect ke halaman home
        }

        // Ambil data akta cerai dengan join ke tabel perkara dan urutkan berdasarkan tanggal_pendaftaran DESC
        $this->aktaCeraiModel->select('t_akta_cerai.*, t_perkara.no_perkara, t_perkara.nama_penggugat, t_perkara.nama_tergugat, t_perkara.tanggal_pendaftaran');
        $this->aktaCeraiModel->join('t_perkara', 't_perkara.id_perkara = t_akta_cerai.id_perkara', 'left');
        $this->aktaCeraiModel->orderBy('t_perkara.tanggal_pendaftaran', 'DESC'); // Urutkan berdasarkan tanggal pendaftaran terbaru
        $akta_cerai = $this->aktaCeraiModel->findAll();

        // Ambil no_perkara yang belum ada di t_akta_cerai
        $no_perkara_options = $this->perkaraModel
            ->select('id_perkara, no_perkara, nama_penggugat')
            ->whereNotIn('id_perkara', function ($builder) {
                return $builder->select('id_perkara')->from('t_akta_cerai');
            })
            ->get()
            ->getResultArray();

        // Data yang akan dikirim ke view
        $data = [
            'title' => 'Daftar Akta Cerai',
            'akta_cerai' => $akta_cerai,
            'no_perkara_options' => $no_perkara_options // Siapkan data untuk dropdown
        ];

        return view('admin/pages/data_akta_cerai', $data);
    }

    public function saveAktaCerai()
    {
        // Validasi input
        if (!$this->validate([
            'id_perkara' => 'required|integer',
            'no_akta_cerai' => 'required',
            'no_seri' => 'required',
            'tanggal_terbit' => 'required|valid_date[Y-m-d]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil data dari form
        $data = [
            'id_perkara'      => $this->request->getPost('id_perkara'),
            'no_akta_cerai'   => $this->request->getPost('no_akta_cerai'),
            'no_seri'         => $this->request->getPost('no_seri'),
            'tanggal_terbit'  => $this->request->getPost('tanggal_terbit'),
        ];

        // Array bulan dalam bahasa Indonesia
        $bulanIndonesia = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        // Format ulang tanggal ke format "d F Y" dalam bahasa Indonesia
        $tanggal = date("d", strtotime($data['tanggal_terbit']));
        $bulan = $bulanIndonesia[date("m", strtotime($data['tanggal_terbit']))];
        $tahun = date("Y", strtotime($data['tanggal_terbit']));
        $formattedDate = "{$tanggal} {$bulan} {$tahun}";

        // Ambil data dari tabel settings
        $settings = $this->settingModel->getSettings(); // Pastikan Anda memiliki model untuk settings

        // Ambil data terkait nomor WhatsApp dan nama penggugat dari tabel perkara
        $perkara = $this->perkaraModel->find($data['id_perkara']);
        $noWhatsapp = '62' . substr($perkara['no_whatsapp'], 1);
        $namaPenggugat = $perkara['nama_penggugat'];
        $noSeri = $this->request->getPost('no_seri');
        $delivery = (string) $settings['delivery'];

        // Siapkan pesan
        $message = "Akta cerai dengan No. Perkara: {$perkara['no_perkara']} A/n {$namaPenggugat} telah terbit dengan Nomor Seri {$noSeri} pada tanggal {$formattedDate}. Akta cerai dapat diambil di Pengadilan Agama Tanggamus atau dapat mengajukan permohonan delivery akta cerai di link berikut: {$delivery}";

        // Konversi data settings ke string
        $apiKey = (string) $settings['apikey'];
        $waGateway = (string) $settings['wa_gateway'];
        $waSender = (string) $settings['wa_sender'];

        // Siapkan data untuk request
        $requestData = [
            "api_key" => $apiKey, // Mengambil API key dari settings
            "sender" => $waSender, // Mengambil nomor pengirim dari settings
            "number" => $noWhatsapp,
            "message" => $message
        ];

        // dd($requestData);
        // die;

        // Kirim pesan WhatsApp dengan cURL
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $waGateway, // Mengambil URL gateway dari settings
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ],
            CURLOPT_POSTFIELDS => json_encode($requestData)
        ]);

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Cek respons dan status kode
        if ($httpcode == 200) {
            // Simpan ke database jika pengiriman berhasil
            $this->aktaCeraiModel->insert($data);
            return redirect()->to(base_url('/admin/aktacerai'))->with('success', 'Akta Cerai berhasil diterbitkan dan notifikasi WA dikirim!');
        } else {
            // Gagal mengirim WA, tampilkan pesan error
            return redirect()->back()->with('error', 'Akta Cerai diterbitkan, tapi gagal mengirim notifikasi WA.');
        }
    }

    public function deleteAktaCerai($id): mixed
    {
        // Periksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/')); // Redirect ke halaman home
        }

        // Hapus data akta cerai berdasarkan ID
        $deleted = $this->aktaCeraiModel->delete($id);

        // Cek apakah penghapusan berhasil
        if ($deleted) {
            return redirect()->to('/admin/aktacerai')->with('success', 'Akta Cerai berhasil dihapus!');
        } else {
            return redirect()->to('/admin/aktacerai')->with('error', 'Gagal menghapus Akta Cerai!');
        }
    }

    public function updateAktaCerai($id)
    {
        // Periksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/')); // Redirect ke halaman home
        }

        // Validasi data yang dikirimkan
        $validation = \Config\Services::validation();
        $validation->setRules([
            'id_perkara' => 'required',
            'no_akta_cerai' => 'required',
            'no_seri' => 'required',
            'tanggal_terbit' => 'required|valid_date[Y-m-d]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal, kembali ke halaman edit dengan pesan error
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }

        // Ambil data yang diinputkan
        $data = [
            'id_perkara'      => $this->request->getPost('id_perkara'),
            'no_akta_cerai'   => $this->request->getPost('no_akta_cerai'),
            'no_seri'         => $this->request->getPost('no_seri'),
            'tanggal_terbit'  => $this->request->getPost('tanggal_terbit')
        ];

        // Update data di database
        try {
            $this->aktaCeraiModel->update($id, $data);

            // Set flashdata untuk notifikasi sukses
            return redirect()->to('/admin/aktacerai')->with('success', 'Data Akta Cerai berhasil diperbarui.');
        } catch (\Exception $e) {
            // Set flashdata untuk notifikasi error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function reminder()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $data = [
            'title' => 'Pengingat Akta Cerai'
        ];

        return view('admin/pages/reminder', $data);
    }

    public function sendReminderNotification()
    {
        $reminderDays = $this->request->getPost('reminder_days');
        // dd($reminderDays);
        // die;

        // Log the value for debugging
        log_message('debug', 'Reminder Days: ' . print_r($reminderDays, true));
        if (is_null($reminderDays) || !is_numeric($reminderDays)) {
            log_message('debug', 'reminderDays is NULL or not a number');
            return; // Exit the function if the value is invalid
        }

        // Call the model to get reminder data
        $reminderData = $this->aktaCeraiModel->getReminderData((int)$reminderDays);

        // Log the reminder data
        log_message('debug', 'Reminder Data: ' . print_r($reminderData, true));

        // Initialize message arrays for flash data
        $flashSuccessMessages = [];
        $flashErrorMessages = [];

        // Send notifications for each case
        foreach ($reminderData as $data) {
            $noPerkara = $data['no_perkara'];
            $namaPenggugat = $data['nama_penggugat'];
            $noWhatsApp = $data['no_whatsapp'];

            // Format the WhatsApp number
            $formattedNumber = '62' . substr($noWhatsApp, 1); // Remove leading '0' and add '62'

            // Calculate the reminder date and format it as dd/mm/yyyy
            $reminderDate = date('d/m/Y', strtotime("+{$reminderDays} days"));

            // Compose the message with the reminder date
            $message = "Pemberitahuan: Akta Cerai untuk perkara nomor *{$noPerkara}* atas nama *{$namaPenggugat}* akan segera terbit dalam {$reminderDays} hari lagi atau pada tanggal *{$reminderDate}*.";

            // Prepare the request data for the API
            $settings = $this->settingModel->getSettings(); // Pastikan Anda memiliki model untuk settings

            $apikey = $settings['apikey'];
            $waGateway = $settings['wa_gateway'];
            $sender = $settings['wa_sender'];

            $requestData = [
                "api_key" => $apikey, // Ganti dengan API key Anda
                "sender" => $sender, // Ganti dengan sender Anda
                "number" => $formattedNumber,
                "message" => $message
            ];

            // Send WhatsApp message using cURL
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $waGateway,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json"
                ],
                CURLOPT_POSTFIELDS => json_encode($requestData)
            ]);

            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            // Check response status code
            if ($httpcode == 200) {
                // If sending is successful
                $flashSuccessMessages[] = "Berhasil mengirim notifikasi ke {$namaPenggugat} untuk perkara nomor {$noPerkara}.";
            } else {
                // If sending fails
                log_message('error', "Gagal mengirim notifikasi ke {$namaPenggugat} untuk perkara nomor {$noPerkara}. HTTP Code: {$httpcode}");
                $flashErrorMessages[] = "Gagal mengirim notifikasi ke {$namaPenggugat} untuk perkara nomor {$noPerkara}.";
            }
        }

        // Set flash data
        if (!empty($flashSuccessMessages)) {
            session()->setFlashdata('success_message', implode('<br>', $flashSuccessMessages));
        }
        if (!empty($flashErrorMessages)) {
            session()->setFlashdata('error_message', implode('<br>', $flashErrorMessages));
        }

        // Redirect back to the reminder page
        return redirect()->to(base_url('admin/reminder')); // Adjust if necessary
    }

    public function setting()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $data = [
            'title' => 'Setting',
            'settings' => $this->settingModel->first()
        ];

        return view('admin/pages/setting', $data);
    }

    public function saveSetting()
    {
        // Mengambil data dari POST
        $data = [
            'wa_gateway' => $this->request->getPost('wa_gateway'),
            'wa_sender' => $this->request->getPost('wa_sender'),
            'apikey' => $this->request->getPost('apikey'),
            'penerbitan_akta_cerai' => $this->request->getPost('penerbitan_akta_cerai'),
            'delivery' => $this->request->getPost('delivery'),
            'notifikasi_reminder' => $this->request->getPost('notifikasi_reminder'),
            'notifikasi_penerbitan_akta_cerai' => $this->request->getPost('notifikasi_penerbitan_akta_cerai')
        ];

        // Ambil pengaturan yang ada untuk mendapatkan gambar lama
        $existingSetting = $this->settingModel->getSettings();
        $oldImage = $existingSetting['latar_login'] ?? null;

        // Cek dan simpan file latar login jika ada file baru yang diunggah
        if ($file = $this->request->getFile('latar_login')) {
            if ($file->isValid() && !$file->hasMoved()) {
                // Hapus gambar lama jika ada
                if ($oldImage && file_exists($oldImage)) {
                    unlink($oldImage); // Hapus file gambar lama dari server
                }

                // Simpan file gambar baru
                $newFileName = $file->getRandomName();
                $file->move('uploads', $newFileName);
                $data['latar_login'] = 'uploads/' . $newFileName;
            }
        } else {
            // Jika tidak ada file baru yang diunggah, gunakan gambar yang ada
            $data['latar_login'] = $oldImage; // Tetap menggunakan gambar latar yang ada
        }

        // Simpan pengaturan ke database
        if ($this->settingModel->saveSettings($data)) {
            return redirect()->to('/admin/setting')->with('message', 'Pengaturan berhasil disimpan.');
        } else {
            return redirect()->to('/admin/setting')->with('error_message', 'Pengaturan gagal disimpan.');
        }
    }
}
