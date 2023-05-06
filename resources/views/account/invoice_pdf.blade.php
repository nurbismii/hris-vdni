<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print PaySlip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center lh-1 mb-2">
                    <h6 class="fw-bold">PT VDNI</h6>
                    <span class="fw-normal">SLIP GAJI <br> Periode ({{ date('F Y', strtotime($data->mulai_periode)) }} - {{ date('F Y', strtotime($data->akhir_periode)) }})</span>
                </div>
                <div class="row">
                    <table class="mt-4">
                        <tbody>
                            <tr>
                                <th scope="row">NIK Karyawan</th>
                                <td>{{ $data->employee_id }}</td>
                                <td>Total Hari Kerja</td>
                                <td>{{ $data->jumlah_hari_kerja }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Nama Karyawan</th>
                                <td>{{ Auth::user()->name }}</td>
                                <td>Status Gaji</td>
                                <td>{{ ucfirst($data->status_gaji) }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Departemen</th>
                                <td>{{ $data->departemen }}</td>
                                <td>Divisi</td>
                                <td>{{ ucfirst($data->divisi) }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Posisi</th>
                                <td>{{ $data->posisi }}</td>
                                <td>Hour Machine</td>
                                <td>{{ $data->jumlah_hour_machine }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="mt-4 table table-bordered">
                        <thead class="small text-uppercase text-muted bg-gradient-primary-to-secondary">
                            <tr>
                                <th scope="col">Detail Gaji</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Deductions</th>
                                <th scope="col">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Gaji</th>
                                <td>{{ number_format($data->gaji_pokok, 0, ",", ".") }}</td>
                                <td>BPJS TK JHT</td>
                                </td>
                                <td>{{ number_format($data->jht, 0, ",", ".")  }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Tunj. Uang Makan</th>
                                <td>{{ number_format($data->tunjangan_umum, 0, ",", ".")  }}</td>
                                <td>BPJS TK JP</td>
                                <td>{{ number_format($data->jp, 0, ",", ".")  }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Tunj. Pengawas</th>
                                <td>{{ number_format($data->tunjangan_pengawas, 0, ",", ".")  }}</td>
                                <td>BPSJ Kesehatan</td>
                                <td>{{ number_format($data->bpjs_kesehatan, 0, ",", ".")  }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Tunj. Koefisien</th>
                                <td>{{ number_format($data->tunjugan_koefisien, 0, ",", ".")  }}</td>
                                <td>Deduction Unpaid Leave</td>
                                <td>{{ number_format($data->deduction_unpaid_leave, 0, ",", ".")  }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Tunj. Masa Kerja</th>
                                <td>0.00 </td>
                                <td>Deduction</td>
                                <td>{{ number_format($data->tunjangan_mk, 0, ",", ".")  }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Lembur</th>
                                <td>0.00 </td>
                                <td>Deduction PPH 21</td>
                                <td>{{ number_format($data->deduction_php21, 0, ",", ".")  }}</td>
                            </tr>
                            <tr>
                                <th scope="row"></th>
                                <td></td>
                                <td>Durasi SP</td>
                                <td>-</td>
                            </tr>
                            <tr class="border-top">
                                <th scope="row">Total Penghasilan</th>
                                <td>Rp.{{ number_format($total_diterima) }}</td>
                                <td>Total Deductions</td>
                                <td>Rp.{{ number_format($total_deduction) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <br>
                        <span class="fw-bold">Gaji Bersih : Rp.{{ number_format($gaji_bersih, 0, ",", ".") }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>