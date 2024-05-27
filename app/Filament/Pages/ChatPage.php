<?php

namespace App\Filament\Pages;

use Filament\Facades\Filament;
use Filament\Pages\Page;

class ChatPage extends Page
{
    // protected static ?string $navigationIcon = 'heroicon-o-document-text';
    // protected static ?string $navigationIcon = 'heroicon-o-chat';

    protected static string $view = 'filament.pages.chat-page';

    protected static ?string $navigationLabel = 'Chats';

    protected static ?string $slug = 'chats';

    // protected static string $layout = 'components.layouts.app';
    
    protected static ?string $title = '';
}
