<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OpportunityResource\Pages;
use App\Models\Opportunity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OpportunityResource extends Resource
{
    protected static ?string $model = Opportunity::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Opportunités';
    protected static ?string $navigationGroup = 'Contenu';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Titre')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, Forms\Set $set) =>
                        $set('slug', \Illuminate\Support\Str::slug($state))),

                Forms\Components\TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true),

                Forms\Components\Select::make('type')
                    ->label('Type')
                    ->options(['stage' => 'Stage', 'bourse' => 'Bourse', 'projet' => 'Projet'])
                    ->required(),

                Forms\Components\TextInput::make('organization')->label('Organisation'),
                Forms\Components\TextInput::make('location')->label('Lieu'),
                Forms\Components\DatePicker::make('deadline')->label('Date limite'),
                Forms\Components\TextInput::make('external_url')->label('Lien externe')->url(),

                Forms\Components\Textarea::make('description')->label('Description courte')->rows(3)->columnSpanFull(),
                Forms\Components\RichEditor::make('content')->label('Description complète')->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Publication')->schema([
                Forms\Components\Select::make('status')
                    ->label('Statut')
                    ->options(['draft' => 'Brouillon', 'published' => 'Publié', 'archived' => 'Archivé', 'expired' => 'Expiré'])
                    ->required(),
                Forms\Components\FileUpload::make('cover_image')->label('Image')->image()->directory('opportunities'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Titre')->searchable()->limit(45),
                Tables\Columns\BadgeColumn::make('type')->label('Type')
                    ->colors(['primary' => 'stage', 'success' => 'bourse', 'warning' => 'projet']),
                Tables\Columns\TextColumn::make('organization')->label('Organisation'),
                Tables\Columns\TextColumn::make('deadline')->label('Date limite')->date('d M Y')->sortable(),
                Tables\Columns\BadgeColumn::make('status')->label('Statut')
                    ->colors(['warning' => 'draft', 'success' => 'published', 'danger' => fn($state) => in_array($state, ['archived', 'expired'])]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')->options(['stage' => 'Stage', 'bourse' => 'Bourse', 'projet' => 'Projet']),
                Tables\Filters\SelectFilter::make('status')->options(['draft' => 'Brouillon', 'published' => 'Publié', 'expired' => 'Expiré']),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->defaultSort('deadline', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOpportunities::route('/'),
            'create' => Pages\CreateOpportunity::route('/create'),
            'edit' => Pages\EditOpportunity::route('/{record}/edit'),
        ];
    }
}
