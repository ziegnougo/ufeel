<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Models\Member;
use App\Services\MemberCardService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Membres';
    protected static ?string $navigationGroup = 'Gestion';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Compte utilisateur')->schema([
                Forms\Components\TextInput::make('user.name')->label('Nom complet')->required(),
                Forms\Components\TextInput::make('user.email')->label('Email')->email()->required(),
                Forms\Components\TextInput::make('user.phone')->label('Téléphone'),
            ])->columns(3),

            Forms\Components\Section::make('Profil membre')->schema([
                Forms\Components\TextInput::make('member_number')->label('N° membre')->disabled(),
                Forms\Components\Select::make('status')
                    ->label('Statut')
                    ->options(['pending' => 'En attente', 'active' => 'Actif', 'inactive' => 'Inactif', 'suspended' => 'Suspendu'])
                    ->required(),
                Forms\Components\DatePicker::make('birth_date')->label('Date de naissance'),
                Forms\Components\Select::make('gender')
                    ->label('Genre')
                    ->options(['homme' => 'Homme', 'femme' => 'Femme', 'autre' => 'Autre']),
                Forms\Components\TextInput::make('city')->label('Ville'),
                Forms\Components\TextInput::make('school_or_university')->label('École / Université'),
                Forms\Components\Select::make('level')
                    ->label('Niveau')
                    ->options(['eleve' => 'Élève', 'etudiant' => 'Étudiant', 'autre' => 'Autre']),
                Forms\Components\Textarea::make('bio')->label('Bio')->rows(3)->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('member_number')->label('N° Membre')->searchable(),
                Tables\Columns\TextColumn::make('user.name')->label('Nom')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user.email')->label('Email')->searchable(),
                Tables\Columns\TextColumn::make('city')->label('Ville'),
                Tables\Columns\BadgeColumn::make('status')->label('Statut')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'active',
                        'danger' => 'suspended',
                        'secondary' => 'inactive',
                    ]),
                Tables\Columns\IconColumn::make('activeSubscription.status')
                    ->label('Cotisation')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\TextColumn::make('created_at')->label('Inscrit le')->date('d M Y')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['pending' => 'En attente', 'active' => 'Actif', 'inactive' => 'Inactif', 'suspended' => 'Suspendu']),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('activate')
                    ->label('Activer')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn(Member $record) => $record->status === 'pending')
                    ->action(function (Member $record) {
                        $record->update(['status' => 'active']);
                        app(MemberCardService::class)->issueCard($record);
                        Notification::make()->title('Membre activé')->success()->send();
                    }),
                Tables\Actions\Action::make('download_card')
                    ->label('Carte PDF')
                    ->icon('heroicon-o-identification')
                    ->color('info')
                    ->url(fn(Member $record) => route('member.card.pdf', $record))
                    ->openUrlInNewTab(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembers::route('/'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}
