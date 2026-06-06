<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Menber;

class FixAdminStatus extends Command
{
    protected $signature = 'app:fix-admin-status';

    protected $description = 'Fix admin users status';

    public function handle(): int
    {
        $count = Menber::where('Permission', 1)->where('Status', '!=', 1)->update(['Status' => 1]);

        $this->info("已更新 {$count} 个管理员账号的状态为启用。");

        return Command::SUCCESS;
    }
}
