<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;


class CheckSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'تحديث حالة الاشتراكات إذا انتهت';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $subscriptions = Subscription::where('status', 'active')->get();

        foreach ($subscriptions as $subscription) {
            $subscription->expireIfNeeded();
        }

        $this->info('تم فحص الاشتراكات وتحديث المنتهية ✅');
    }

    
}
