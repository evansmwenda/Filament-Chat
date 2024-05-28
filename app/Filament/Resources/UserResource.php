<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Conversation;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Redirect;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User Details')
                ->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('email')->email()->required(),
                    FileUpload::make('image')
                    ->image()
                    ->imageEditor()
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')
                ->color('gray')
                ->limit(50)
                ->searchable(),   
                ImageColumn::make('image')
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('gotoChat')
                ->label(' Message')
                ->action(function($record){
                   //check if conversation exists
                    $senderId = auth()->user()->id;
                    $receiverId = $record->id;

                    $conversationExists = Conversation::where(function($query) use ($senderId, $receiverId) {
                        $query->where('sender_id', $senderId)
                                ->where('receiver_id', $receiverId);
                    })->orWhere(function($query) use ($senderId, $receiverId) {
                        $query->where('sender_id', $receiverId)
                                ->where('receiver_id', $senderId);
                    })->exists();

                    if ($conversationExists) {
                        Notification::make()
                            ->title('Conversation already exists')
                            ->warning()
                            ->send();

                        //redirect to chats screen
                        Redirect::to('/admin/chats');
                    } else {
                        Conversation::create([
                            'sender_id' => $senderId,
                            'receiver_id' => $receiverId,
                        ]);

                        Notification::make()
                            ->title('Conversation created successfully')
                            ->success()
                            ->send();

                        //redirect to chats screen
                        Redirect::to('/admin/chats');
                    }
                })
                ->requiresConfirmation()
                ->button()
                ->icon('heroicon-o-plus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            // 'create' => Pages\CreateUser::route('/create'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    // public static function canViewAny(): bool 
    // {
    //     return auth()->user()->is_admin;
    // }
}
