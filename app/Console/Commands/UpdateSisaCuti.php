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
        $today = now();
        $data = employee::whereMonth('entry_date', $today->month)->whereDay('entry_date', $today->day)->get();
        Log::info($data);
        foreach ($data as $row) {
            if ($row->sisa_cuti != 12) {
                employee::where('nik', $row->nik)->update([
                    'sisa_cuti' => '12',
                ]);
            }
        }
    }
}