<?php

namespace App\Filament\Widgets;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::count())
            ->description('Number of Users')
            ->color('success')
            ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('Messages Sent', Message::count())
            ->description('Messages Sent')
            ->color('warning'),
            Stat::make('Conversations', Conversation::count())
            ->description('All Conversations')
            ->color('info'),
        ];
    }

    public static function canView(): bool 
    {
        return auth()->user()->is_admin;
    }
}
