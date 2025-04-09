<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Exception;

class Livedata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'livedata:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        // while (true) {
        //     $livedata= Http::get('http://122.187.205.206:5008/api/Values/GetAllData?key=steam8108');
        //     $input = [
        //         'livedata'=>$livedata,
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ];
            
        //     $updatedata=DB::table('livedata')->where('id',1)->update($input);
        //     sleep(60); 
        // } 

        try {

            $livedata= Http::get('http://122.187.205.206:5008/api/Values/GetAllData?key=steam8108');

            $input = [
                'livedata'=>$livedata,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $updatedata=DB::table('livedata')->where('id',1)->update($input);

            // Log::info($updatedata);

        } catch (Exception $e) {
            return response()->json('error', $e);
        }
    }
}