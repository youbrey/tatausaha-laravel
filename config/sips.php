<?php

// config/sips.php
// Pengaturan khusus aplikasi SIPS, terpisah dari config Laravel inti
// agar mudah dimodifikasi tanpa menyentuh file framework.

return [
    'instansi' => env('SIPS_INSTANSI', 'DPRD Kota Bitung'),
    'alamat' => env('SIPS_ALAMAT', ''),
    'kop_logo' => env('SIPS_KOP_LOGO', 'logo_instansi.png'),

    'jenis_surat' => [
        'PERJALANAN_DINAS_DPRD' => 'Perjalanan Dinas - DPRD',
        'PERJALANAN_DINAS_ASN' => 'Perjalanan Dinas - ASN',
        'PERJALANAN_DINAS_GABUNGAN' => 'Perjalanan Dinas - Gabungan',
        'UNDANGAN_PARIPURNA' => 'Undangan Rapat Paripurna',
        'UNDANGAN_BIASA' => 'Undangan Rapat AKD',
    ],

    'kategori_dprd' => [
        'PIMPINAN_DPRD' => 'Pimpinan DPRD',
        'KOMISI_I' => 'Komisi I',
        'KOMISI_II' => 'Komisi II',
        'KOMISI_III' => 'Komisi III',
        'CUSTOM' => 'Lainnya',
    ],

    'prefix_nomor' => [
        'surat_tugas' => 'ST',
        'sppd' => 'SPPD',
        'undangan' => 'UND',
    ],
];
