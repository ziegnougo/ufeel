<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Actualités';
    protected static ?string $navigationGroup = 'Contenu';
    protected static ?int $navigationSort = 2;

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

                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\Select::make('category')
                    ->label('Catégorie')
                    ->options([
                        'actualites' => 'Actualités',
                        'solidarite' => 'Solidarité',
                        'recompenses' => 'Récompenses',
                        'annonces' => 'Annonces',
                    ])
                    ->required(),

                Forms\Components\Toggle::make('is_featured')->label('À la une'),

                Forms\Components\Textarea::make('excerpt')->label('Résumé')->rows(3)->columnSpanFull(),
                Forms\Components\RichEditor::make('content')->label('Contenu')->required()->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Publication')->schema([
                Forms\Components\Select::make('status')
                    ->label('Statut')
                    ->options(['draft' => 'Brouillon', 'published' => 'Publié', 'archived' => 'Archivé'])
                    ->required(),
                Forms\Components\DateTimePicker::make('published_at')->label('Date de publication'),
                Forms\Components\FileUpload::make('cover_image')
                    ->label('Image')
                    ->image()
                    ->directory('posts'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->label(''),
                Tables\Columns\TextColumn::make('title')->label('Titre')->searchable()->limit(50),
                Tables\Columns\BadgeColumn::make('category')->label('Catégorie'),
                Tables\Columns\IconColumn::make('is_featured')->label('Une')->boolean(),
                Tables\Columns\BadgeColumn::make('status')->label('Statut')
                    ->colors(['warning' => 'draft', 'success' => 'published', 'danger' => 'archived']),
                Tables\Columns\TextColumn::make('published_at')->label('Publié le')->date('d M Y')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options(['actualites' => 'Actualités', 'solidarite' => 'Solidarité', 'recompenses' => 'Récompenses', 'annonces' => 'Annonces']),
                Tables\Filters\SelectFilter::make('status')
                    ->options(['draft' => 'Brouillon', 'published' => 'Publié']),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
