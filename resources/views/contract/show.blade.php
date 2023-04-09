<x-app-layout title="Invoice">

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @endpush

    <!-- Main page content-->
    <div class="container-xl px-4 mt-4">
        <!-- Invoice-->
        <div class="card invoice">
            <div class="card-header p-4 p-md-5 border-bottom-0 bg-gradient-primary-to-secondary text-white-50">
                <div class="row justify-content-between align-items-center">
                    <div class="col-12 col-lg-auto mb-5 mb-lg-0 text-center text-lg-start">
                        <!-- Invoice branding-->
                        <img class="invoice-brand-img rounded mb-4" src="{{ asset('assets/img/backgrounds/vdni-ikon.png')}}" alt="" />
                        <div class="h2 text-white mb-0">{{ $contract->no_pkwt }}</div>
                        {{ $contract->nama }}
                    </div>
                    <div class="col-12 col-lg-auto text-center text-lg-end">
                        <!-- Invoice details-->
                        <div class="h3 text-white">{{ $contract->jabatan }}</div>
                        <table>
                            <tbody>
                                <tr>
                                    <td>NIK</td>
                                    <td></td>
                                    <td>:</td>
                                    <td></td>
                                    <td>{{ $contract->nik }}</td>
                                </tr>
                                <tr>
                                    <td>No KTP</td>
                                    <td></td>
                                    <td>:</td>
                                    <td></td>
                                    <td>{{ $contract->no_ktp }}</td>
                                </tr>
                                <tr>
                                    <td>Durasi Kontrak</td>
                                    <td></td>
                                    <td>:</td>
                                    <td></td>
                                    <td>{{ $contract->lama_kontrak }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-body p-4 p-md-5">
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <thead class="border-bottom">
                            <tr class="small text-uppercase text-muted">
                                <th scope="col">Deskripsi</th>
                                <th class="text-end" scope="col"></th>
                                <th class="text-end" scope="col"></th>
                                <th class="text-end" scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Invoice item 1-->
                            <tr class="border-bottom">
                                <td>
                                    <div class="fw-bold">Tanggal mulai kontrak</div>
                                </td>
                                <td class="text-end fw-bold"></td>
                                <td class="text-end fw-bold">:</td>
                                <td class="text-end fw-bold">{{ date('d F Y', strtotime($contract->tanggal_mulai_kontrak)) }}</td>
                            </tr>
                            <!-- Invoice item 2-->
                            <tr class="border-bottom">
                                <td>
                                    <div class="fw-bold">Tanggal berakhir kontrak</div>
                                </td>
                                <td class="text-end fw-bold"></td>
                                <td class="text-end fw-bold">:</td>
                                <td class="text-end fw-bold">{{ date('d F Y', strtotime($contract->tanggal_berakhir_kontrak)) }}</td>
                            </tr>
                            <tr class="border-bottom">
                                <td>
                                    <div class="fw-bold">Gaji</div>
                                </td>
                                <td class="text-end fw-bold"></td>
                                <td class="text-end fw-bold">:</td>
                                <td class="text-end fw-bold">Rp{{ number_format($contract->gaji) }}</td>
                            </tr>
                            <tr class="border-bottom">
                                <td>
                                    <div class="fw-bold">Uang Makan</div>
                                </td>
                                <td class="text-end fw-bold"></td>
                                <td class="text-end fw-bold">:</td>
                                <td class="text-end fw-bold">Rp{{ number_format($contract->uang_makan) }}</td>
                            </tr>
                            <tr class="border-bottom">
                                <td>
                                    <div class="fw-bold">Hour Machine</div>
                                </td>
                                <td class="text-end fw-bold"></td>
                                <td class="text-end fw-bold">:</td>
                                <td class="text-end fw-bold">Rp{{ number_format($contract->hm) }}</td>
                            </tr>
                            <tr class="border-bottom">
                                <td>
                                    <div class="fw-bold">Tunjangan Jabatan</div>
                                </td>
                                <td class="text-end fw-bold"></td>
                                <td class="text-end fw-bold">:</td>
                                <td class="text-end fw-bold">{{ $contract->tunjangan_jabatan }}</td>
                            </tr>
                            <tr class="border-bottom">
                                <td>
                                    <div class="fw-bold">Tunjangan Jabatan</div>
                                </td>
                                <td class="text-end fw-bold"></td>
                                <td class="text-end fw-bold">:</td>
                                <td class="text-end fw-bold">{{ $contract->keterangan_kontrak }}</td>
                            </tr>
                            <tr class="border-bottom">
                                <td>
                                    <div class="fw-bold">Status</div>
                                </td>
                                <td class="text-end fw-bold"></td>
                                <td class="text-end fw-bold">:</td>
                                <td class="text-end fw-bold">{{ $contract->status ?? '-' }}</td>
                            </tr>
                            <tr class="border-bottom">
                                <td>
                                    <div class="fw-bold">Status Perkawinan</div>
                                </td>
                                <td class="text-end fw-bold"></td>
                                <td class="text-end fw-bold">:</td>
                                <td class="text-end fw-bold">{{ $contract->status_perkawinan ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer p-4 p-lg-5 border-top-0">
                    <div class="row">
                        <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                            <!-- Invoice - sent to info-->
                            <div class="small text-muted text-uppercase fw-700 mb-2">To</div>
                            <div class="h6 mb-1">{{ $contract->nama }}</div>
                            <div class="small">{{ ucwords(strtolower($contract->alamat)) }}</div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                            <!-- Invoice - sent from info-->
                            <div class="small text-muted text-uppercase fw-700 mb-2">From</div>
                            <div class="h6 mb-0">PT VDNI</div>
                            <div class="small">Puuruy, Kec. Bondoala, Kabupaten Konawe</div>
                            <div class="small">Sulawesi Tenggara 93354</div>
                        </div>
                        <div class="col-lg-6">
                            <!-- Invoice - additional notes-->
                            <div class="small text-muted text-uppercase fw-700 mb-2">Note</div>
                            <div class="small mb-0">Payment is due 15 days after receipt of this invoice. Please make checks or money orders out to Company Name, and include the invoice number in the memo. We appreciate your business, and hope to be working with you again very soon!</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="{{ asset('js/datatables/datatables-simple-demo.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/litepicker.js')}}"></script>
        <script src="{{ asset('js/app.js')}}"></script>
        @endpush

</x-app-layout>