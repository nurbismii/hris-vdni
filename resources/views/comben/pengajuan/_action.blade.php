<div class="dropdown">
    <button class="btn btn-sm btn-primary dropdown-toggle" id="dropdownFadeIn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
    <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownFadeIn">
        <a href="{{ $url_update_diterima }}" class="dropdown-item" onclick="return confirmApprove()">Setuju</a>
        <a href="{{ $url_update_ditolak }}" class="dropdown-item" onclick="return confirmReject()">Tidak</a>
        <a href="{{ $url_foto }}" target="_blank" class="dropdown-item">Lihat Bukti</a>
        <a href="{{ $url_delete }}" class="dropdown-item" onclick="return confirmDestroy()">Hapus</a>
    </div>
</div>
