<?php

namespace App\Filament\Pages;

use App\Models\Event;
use App\Models\Member;
use App\Models\Post;
use App\Models\Subscription;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $title = 'Tableau de bord';
}
