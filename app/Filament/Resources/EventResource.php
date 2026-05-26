<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Événements';
    protected static ?string $navigationGroup = 'Contenu';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informations générales')->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Titre')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, Forms\Set $set) =>
                        $set('slug', \Illuminate\Support\Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\Textarea::make('excerpt')
                    ->label('Résumé')
                    ->rows(2)
                    ->columnSpanFull(),

                Forms\Components\RichEditor::make('content')
                    ->label('Description complète')
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Lieu & Dates')->schema([
                Forms\Components\TextInput::make('location')->label('Lieu'),
                Forms\Components\TextInput::make('address')->label('Adresse'),
                Forms\Components\DateTimePicker::make('starts_at')->label('Début')->required(),
                Forms\Components\DateTimePicker::make('ends_at')->label('Fin'),
                Forms\Components\TextInput::make('max_participants')
                    ->label('Participants max')
                    ->numeric()
                    ->nullable(),
            ])->columns(2),

            Forms\Components\Section::make('Publication')->schema([
                Forms\Components\Select::make('status')
                    ->label('Statut')
                    ->options(['draft' => 'Brouillon', 'published' => 'Publié', 'archived' => 'Archivé'])
                    ->required(),
                Forms\Components\FileUpload::make('cover_image')
                    ->label('Image de couverture')
                    ->image()
                    ->directory('events'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->label(''),
                Tables\Columns\TextColumn::make('title')->label('Titre')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('starts_at')->label('Début')->dateTime('d M Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('location')->label('Lieu'),
                Tables\Columns\BadgeColumn::make('status')->label('Statut')
                    ->colors(['warning' => 'draft', 'success' => 'published', 'danger' => 'archived']),
                Tables\Columns\TextColumn::make('registrations_count')
                    ->label('Inscrits')
                    ->counts('registrations'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['draft' => 'Brouillon', 'published' => 'Publié', 'archived' => 'Archivé']),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('starts_at', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
