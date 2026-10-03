<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Opportunity;
use App\Models\Partner;
use App\Models\Post;
use App\Models\SiteStat;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'superadmin')->first() ?? User::first();

        $posts = [
            [
                'title'    => 'Lancement officiel de la plateforme numérique UFEEL',
                'excerpt'  => 'L\'UFEEL lance sa plateforme digitale : actualités, événements, opportunités et ressources réunies au même endroit pour tous les membres.',
                'content'  => 'L\'Union Fraternelle des Élèves et Étudiants de Lafi franchit une nouvelle étape avec le lancement de sa plateforme numérique. Créez votre compte, rejoignez les événements et accédez aux opportunités en un clic.',
                'category' => 'annonces',
            ],
            [
                'title'    => 'Caravane de dons de fournitures scolaires à Lafi',
                'excerpt'  => 'Plus de 200 élèves de Lafi ont reçu kits scolaires et manuels lors de notre caravane annuelle de solidarité.',
                'content'  => 'Merci à tous les bénévoles et donateurs qui ont rendu possible cette journée de solidarité au profit des élèves des collèges et lycées de Lafi.',
                'category' => 'solidarite',
            ],
            [
                'title'    => 'Cérémonie de remise de prix aux meilleurs étudiants',
                'excerpt'  => 'Les lauréats du concours d\'excellence 2026 ont été honorés lors d\'une cérémonie en présence des partenaires de l\'union.',
                'content'  => 'Félicitations aux lauréats ! Le concours d\'excellence récompense chaque année les meilleurs résultats académiques des membres de l\'union.',
                'category' => 'recompenses',
            ],
            [
                'title'    => 'Atelier : préparer efficacement le BAC',
                'excerpt'  => 'Nos anciens partagent leurs méthodes de révision et de gestion du temps pour réussir le BAC sereinement.',
                'content'  => 'Retour sur l\'atelier animé par nos étudiants en faculté : planning de révision, fiches méthodes et séances de questions-réponses.',
                'category' => 'actualites',
            ],
        ];

        foreach ($posts as $i => $data) {
            Post::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($data['title'])],
                [
                    'title'        => $data['title'],
                    'excerpt'      => $data['excerpt'],
                    'content'      => $data['content'],
                    'category'     => $data['category'],
                    'status'       => 'published',
                    'published_at' => now()->subDays($i * 3 + 1),
                    'author_id'    => $admin?->id,
                ]
            );
        }

        $events = [
            [
                'title'    => 'Assemblée générale ordinaire 2026',
                'excerpt'  => 'Bilan d\'activités, rapport financier et élection du nouveau bureau.',
                'content'  => 'Tous les membres sont conviés à l\'assemblée générale annuelle.',
                'location' => 'Maison des jeunes, Lafi',
                'starts_at'=> now()->addDays(12)->setTime(15, 0),
            ],
            [
                'title'    => 'Journée porte ouverte & orientation scolaire',
                'excerpt'  => 'Rencontres avec des étudiants des grandes écoles et universités de Côte d\'Ivoire.',
                'content'  => 'Venez poser toutes vos questions sur les filières, les concours et les bourses.',
                'location' => 'Lycée municipal de Lafi',
                'starts_at'=> now()->addDays(25)->setTime(9, 0),
            ],
            [
                'title'    => 'Tournoi inter-générations : football & fraternité',
                'excerpt'  => 'Matchs amicaux entre élèves, étudiants et anciens de l\'union.',
                'content'  => 'Inscriptions d\'équipes ouvertes jusqu\'à la veille de l\'événement.',
                'location' => 'Terrain municipal, Lafi',
                'starts_at'=> now()->addDays(40)->setTime(16, 0),
            ],
        ];

        foreach ($events as $data) {
            Event::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($data['title'])],
                [
                    'title'      => $data['title'],
                    'excerpt'    => $data['excerpt'],
                    'content'    => $data['content'],
                    'location'   => $data['location'],
                    'status'     => 'published',
                    'starts_at'  => $data['starts_at'],
                    'created_by' => $admin?->id,
                ]
            );
        }

        $opportunities = [
            [
                'title'       => 'Bourse d\'excellence de la Fondation pour la jeunesse',
                'description' => 'Bourse annuelle destinée aux élèves et étudiants résidant à Lafi, sur dossier.',
                'type'        => 'bourse',
                'organization'=> 'Fondation pour la jeunesse ivoirienne',
                'location'    => 'Côte d\'Ivoire',
                'deadline'    => now()->addDays(30),
            ],
            [
                'title'       => 'Stage en comptabilité — Cabinet AKÉ Group',
                'description' => 'Stage de 6 mois pour étudiants en gestion, comptabilité ou finance.',
                'type'        => 'stage',
                'organization'=> 'AKÉ Group, Abidjan',
                'location'    => 'Abidjan',
                'deadline'    => now()->addDays(18),
            ],
            [
                'title'       => 'Projet jeunes : création d\'un club lecture UFEEL',
                'description' => 'Appel à volontaires pour animer le nouveau club de lecture de l\'union.',
                'type'        => 'projet',
                'organization'=> 'UFEEL',
                'location'    => 'Lafi',
                'deadline'    => now()->addDays(45),
            ],
        ];

        foreach ($opportunities as $data) {
            Opportunity::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($data['title'])],
                [
                    'title'       => $data['title'],
                    'description' => $data['description'],
                    'type'        => $data['type'],
                    'organization'=> $data['organization'],
                    'location'    => $data['location'],
                    'deadline'    => $data['deadline'],
                    'status'      => 'published',
                ]
            );
        }

        $partners = [
            ['name' => 'Mairie de Lafi',              'type' => 'institutionnel', 'display_order' => 1],
            ['name' => 'Inspection Pédagogique',      'type' => 'institutionnel', 'display_order' => 2],
            ['name' => 'Fondation Jeunesse CI',       'type' => 'ong',            'display_order' => 3],
            ['name' => 'Lycée Municipal de Lafi',     'type' => 'institutionnel', 'display_order' => 4],
            ['name' => 'Association des Parents d\'Élèves', 'type' => 'ong',      'display_order' => 5],
        ];

        foreach ($partners as $data) {
            Partner::firstOrCreate(
                ['name' => $data['name']],
                [
                    'type'          => $data['type'],
                    'display_order' => $data['display_order'],
                    'is_active'     => true,
                ]
            );
        }

        // Statistiques d'illustration (modifiables dans /admin)
        $statValues = [
            'membres_actifs' => 320,
            'activites'      => 48,
            'jeunes_formes'  => 750,
            'partenaires'    => 12,
        ];
        foreach ($statValues as $key => $value) {
            SiteStat::where('key', $key)->update(['value' => $value]);
        }
    }
}
