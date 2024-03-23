window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }

    const datatablesSimpleWilayah = document.getElementById('datatablesSimpleWilayah');
    if (datatablesSimpleWilayah) {
        new simpleDatatablesCustom.DataTable(datatablesSimpleWilayah, {
            config: {
                pageLength: 25 // Ganti dengan jumlah yang Anda inginkan
            }
        });
    }
});
