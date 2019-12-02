<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class cleanMovimientos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:movimientos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpiar ';

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
     * @return mixed
     */
    public function handle()
    {
        
        $ids = DB::table('productos')->pluck('id');
        $delete = DB::table('movimientos')->whereNotIn('producto_id',$ids)->delete();

    }
}
