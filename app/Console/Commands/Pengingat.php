<?php

namespace App\Console\Commands;

use App\Models\Pengingat as ModelsPengingat;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Pengingat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Pengingat:cron';

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
        Log::info('Pengingat berjalan dengan baik.');

        $data = ModelsPengingat::orderBy('tanggal_cuti', 'ASC')->where('tanggal_cuti', '<=', date('Y-m-d', strtotime(Carbon::now()->subDays(14)->toDateTimeString())))->where('tanggal_cuti', '>=', date('Y-m-d', strtotime(Carbon::now()->subDays(14)->toDateTimeString())))->where('flg_kirim', '==', '0')->get();
        Log::info($data);
        foreach($data as $row){
            ModelsPengingat::where('id', $row->id)->update([
                'flg_kirim' => '1',
            ]);
        }
    }
}
