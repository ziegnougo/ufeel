<?php

namespace Database\Seeders;

use App\Models\SiteStat;
use Illuminate\Database\Seeder;

class SiteStatSeeder extends Seeder
{
    public function run(): void
    {
        $stats = [
            ['key' => 'membres_actifs',  'label' => 'Membres actifs',       'value' => 0,  'icon' => 'heroicon-o-users'],
            ['key' => 'activites',       'label' => 'Activités organisées',  'value' => 0,  'icon' => 'heroicon-o-calendar-days'],
            ['key' => 'jeunes_formes',   'label' => 'Jeunes formés',         'value' => 0,  'icon' => 'heroicon-o-academic-cap'],
            ['key' => 'partenaires',     'label' => 'Partenaires',           'value' => 0,  'icon' => 'heroicon-o-building-office-2'],
        ];

        foreach ($stats as $stat) {
            SiteStat::firstOrCreate(
                ['key' => $stat['key']],
                ['label' => $stat['label'], 'value' => $stat['value'], 'icon' => $stat['icon']]
            );
        }
    }
}
