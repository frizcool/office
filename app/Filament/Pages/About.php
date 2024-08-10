<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Livewire\Component;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Fieldset;
 

class About extends Page 
{
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?int $navigationSort = 4;
    public static function getNavigationLabel(): string
    {
        return trans('global.about_apps');
    }
    public function getTitle(): string
    {
        return trans('global.about_apps');
    }
    public static function getNavigationGroup(): ?string
    {
        return __('global.about_apps');
    }
    protected static string $view = 'filament.pages.about';

   
}
