<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Model\Record\Record;
use Illuminate\Console\Command;

class CloseRecord extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'record:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cierra las entradas abiertas y crea un ticket para su revision.';

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
        $now = Carbon::now();
        $records = Record::with('ticket')->whereNull('check_out')->get();

        foreach ($records as $record) {
            $diff = $record->check_in->diffInMinutes($now);

            if ($diff <= config('options.close_after')) {
                continue;
            }

            // Solo pasa si es igual a 0, ya que no se pueden crear solicitudes hasta que el ticket este cerrado.
            if (count($record->ticket) > 0) {
                continue;
            }

            $record->ticket()->create(['user_id' => $record->user_id, 'comments' => 'Check out no realizado.']);
            $record->check_out = $now;
            $record->save();
        }

        $this->info('Records close successfully!');
    }
}
