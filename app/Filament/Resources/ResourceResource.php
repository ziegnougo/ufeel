<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResourceResource\Pages;
use App\Models\Resource as UfeelResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ResourceResource extends Resource
{
    protected static ?string $model = UfeelResource::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Ressources';
    protected static ?string $navigationGroup = 'Contenu';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->label('Titre')->required()->columnSpanFull(),

            Forms\Components\Select::make('type')
                ->label('Catégorie')
                ->options([
                    'bibliotheque' => 'Bibliothèque',
                    'cours' => 'Cours & Formations',
                    'sujets' => 'Sujets Examens',
                    'orientation' => 'Orientation & Conseils',
                    'outils' => 'Outils & Modèles',
                ])
                ->required(),

            Forms\Components\Textarea::make('description')->label('Description')->rows(3)->columnSpanFull(),

            Forms\Components\FileUpload::make('file_url')
                ->label('Fichier')
                ->directory('resources')
                ->acceptedFileTypes(['application/pdf', 'application/zip', 'application/msword']),

            Forms\Components\TextInput::make('external_url')->label('Lien externe')->url(),

            Forms\Components\FileUpload::make('thumbnail')->label('Miniature')->image()->directory('resources/thumbnails'),

            Forms\Components\Toggle::make('is_public')->label('Accessible sans connexion'),

            Forms\Components\Select::make('status')
                ->label('Statut')
                ->options(['draft' => 'Brouillon', 'published' => 'Publié'])
                ->required(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Titre')->searchable()->limit(50),
                Tables\Columns\BadgeColumn::make('type')->label('Catégorie'),
                Tables\Columns\IconColumn::make('is_public')->label('Public')->boolean(),
                Tables\Columns\BadgeColumn::make('status')->label('Statut')
                    ->colors(['warning' => 'draft', 'success' => 'published']),
                Tables\Columns\TextColumn::make('created_at')->label('Ajouté le')->date('d M Y'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options(['bibliotheque' => 'Bibliothèque', 'cours' => 'Cours', 'sujets' => 'Sujets', 'orientation' => 'Orientation', 'outils' => 'Outils']),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResources::route('/'),
            'create' => Pages\CreateResource::route('/create'),
            'edit' => Pages\EditResource::route('/{record}/edit'),
        ];
    }
}
