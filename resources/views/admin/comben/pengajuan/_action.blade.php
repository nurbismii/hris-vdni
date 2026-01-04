<a href="{{ $url_diterima }}" class="btn btn-primary btn-sm mb-2" onclick="return confirmApprove()">Terima</a>
<div class="dropdown">
    <button class="btn btn-sm btn-secondary dropdown-toggle" id="dropdownFadeIn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opsi</button>
    <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownFadeIn">
        <a href="{{ $url_ditolak }}" class="dropdown-item" onclick="return confirmReject()">Tolak</a>
        <a href="{{ $url_delete }}" class="dropdown-item" onclick="return confirmDestroy()">Hapus</a>
        <a href="{{ $url_foto }}" target="_blank" class="dropdown-item">Lihat Bukti</a>
    </div>
</div>