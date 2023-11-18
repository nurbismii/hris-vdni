<?php

namespace App\Console\Commands;

use App\Models\employee;
use App\Models\Resign;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateDataResignKaryawan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resign:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = now();
        $today = date('Y-m-d', strtotime($today));
        $data = Resign::whereDate('tanggal_keluar', '<=', $today)->where('flg_kirim', null)->get();
        Log::info($data);
        foreach ($data as $row) {
            employee::where('nik', $row->nik_karyawan)->update([
                'tgl_resign' => $row->tanggal_keluar,
                'alasan_resign' => $row->alasan_keluar,
                'status_resign' => 'Resign',
                'kategori_keluar' => $row->tipe
            ]);
            Resign::where('nik_karyawan', $row->nik_karyawan)->update([
                'flg_kirim' => '1'
            ]);
        }
    }
}
