<a href="{{ $url_update_diterima }}" title="{{ $data->nama_karyawan }}" class="btn btn-success btn-sm" onclick="return confirmApprove()">Setuju</a>
<a href="{{ $url_update_ditolak }}" title="{{ $data->nama_karyawan }}" class="btn btn-primary btn-sm" onclick="return confirmReject()">Tidak</a>
<a href="{{ $url_foto }}" target="_blank" title="{{ $data->nama_karyawan }}" class="btn btn-info btn-sm">Bukti</a>
<a href="{{ $url_delete }}" title="{{ $data->nama_karyawan }}" class="btn btn-danger btn-sm" onclick="return confirmDestroy()">Hapus</a>
