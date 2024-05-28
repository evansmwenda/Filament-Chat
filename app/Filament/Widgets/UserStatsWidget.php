<?php

namespace App\Filament\Widgets;

use App\Models\Message;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Messages', Message::where('sender_id',auth()->user()->id)->count())
            ->description('Messages Sent Today')
            ->color('success')
            ->descriptionIcon('heroicon-m-arrow-trending-up'),
        ];
    }

    public static function canView(): bool 
    {
        return !(auth()->user()->is_admin);
    }
}
