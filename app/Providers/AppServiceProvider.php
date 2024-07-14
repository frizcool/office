<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TomatoPHP\FilamentUsers\Facades\FilamentUser;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        // FilamentUser::registerAction(\Filament\Actions\Action::make('update'));
        // FilamentUser::registerCreateAction(\Filament\Actions\Action::make('update'));
        // FilamentUser::registerEditAction(\Filament\Actions\Action::make('update'));
        // FilamentUser::registerFormInput(\Filament\Forms\Components\TextInput::make('text'));
        // FilamentUser::registerTableAction(\Filament\Tables\Actions\Action::make('update'));
        // FilamentUser::registerTableColumn(\Filament\Tables\Columns\Column::make('text'));
        // FilamentUser::registerTableFilter(\Filament\Tables\Filters\Filter::make('text'));
    
    }
}
