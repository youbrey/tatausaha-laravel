// Mengubah input "Jakarta, Manado" menjadi beberapa <input name="kota_tujuan[]">
// supaya diterima Laravel sebagai array tanpa perlu library tambahan.
document.addEventListener('submit', function (e) {
    const rawInput = e.target.querySelector('#kota_tujuan_raw');
    if (!rawInput) return;

    const kota = rawInput.value.split(',').map(s => s.trim()).filter(Boolean);

    kota.forEach(function (k) {
        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'kota_tujuan[]';
        hidden.value = k;
        e.target.appendChild(hidden);
    });

    rawInput.removeAttribute('name');
});
