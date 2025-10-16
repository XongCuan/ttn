<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ktech:update-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update data by FB BQT';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        try {
            $this->dbHandle();

            $this->info('Handle Completed!');
        } catch (\Throwable $th) {
            
            $this->error($th->getMessage());
        }
    }

    private function dbHandle()
    {
        Schema::create('working_time_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->tinyInteger('status');
            $table->date('ticket_date');
            $table->tinyInteger('type');
            $table->text('reason')->nullable();
            $table->text('reason_refuse')->nullable();
            $table->text('attachment_path')->nullable();
            $table->timestamps();
        });

        $this->info('Handle DB success!');
    }
}
