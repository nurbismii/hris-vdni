<?php

namespace App\Console\Commands;

use App\Models\employee;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Severancepay as ModelsSeverancepay;

class SeverancePay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'severance:cron';

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
        $current_time = Carbon::now();
        $current_time = date('Y-m-d', strtotime($current_time));
        Log::info($current_time);

        $data = ModelsSeverancepay::whereDate('termination_date', '=' ,$current_time)->where('flg_kirim', null)->get();
        foreach ($data as $row) {
            employee::where('nik', $row->nik_karyawan)->update([
                'status_resign' => 'PHK',
            ]);
        }
        foreach ($data as $row) {
            ModelsSeverancepay::where('id', $row->id)->update([
                'flg_kirim' => '1',
            ]);
        }
    }
}
