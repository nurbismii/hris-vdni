<?php

namespace App\Console\Commands;

use App\Models\employee;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateSisaCuti extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sisa:cuti';

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
        $cuti_tahunan = 12;
        $today = now();
        $data = employee::select('nik', 'sisa_cuti', 'sisa_cuti_covid')->whereMonth('entry_date', $today->month)->whereDay('entry_date', $today->day)->get();
        Log::info($data);
        foreach ($data as $row) {

            if ($row->sisa_cuti < 0) {

                $sisa_cuti_covid = $row->sisa_cuti_covid - abs($row->sisa_cuti);

                if ($sisa_cuti_covid < 0) {

                    $sisa_cuti = $cuti_tahunan - abs($sisa_cuti_covid);

                    employee::where('nik', $row->nik)->update([
                        'sisa_cuti' => $sisa_cuti,
                        'sisa_cuti_covid' => 0
                    ]);
                }

                // employee::where('nik', $row->nik)->update([
                //     'sisa_cuti' => $cuti_tahunan - abs($row->sisa_cuti),
                //     'sisa_cuti_covid' => $sisa_cuti_covid > 0 ? $sisa_cuti_covid : 0
                // ]);
            // } else {

            //     employee::where('nik', $row->nik)->update([
            //         'sisa_cuti' => $cuti_tahunan
            //     ]);
            // }
        }
    }
}
