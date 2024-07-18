<?php
namespace App\Filament\Resources\SuratMasukRelationManagerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\DisposisiList;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Filament\Forms\Components\Section;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use App\Filament\Resources\SuratMasukResource;

class DisposisisRelationManager extends RelationManager
{
    protected static string $relationship = 'disposisis';

    protected static ?string $recordTitleAttribute = 'id';

    protected function getUsersByRole()
    {
        $currentUser = Auth::user();
        $currentUserId = $currentUser->id;

        if ($currentUser->hasRole('super_admin')) {
            return User::where('id', '!=', $currentUserId)->pluck('jabatan', 'id');
        }

        $roleHierarchy = [
            'eselon_pimpinan' => ['eselon_pimpinan', 'eselon_pembantu_pimpinan', 'eselon_pelaksana'],
            'eselon_pembantu_pimpinan' => ['eselon_pembantu_pimpinan', 'eselon_pelaksana'],
        ];

        $currentUserRole = $currentUser->getRoleNames()->first();
        $higherLevelRoles = $roleHierarchy[$currentUserRole] ?? [];

        if (!empty($higherLevelRoles)) {
            return User::role($higherLevelRoles)
                ->where('id', '!=', $currentUserId)
                ->pluck('jabatan', 'id');
        }

        return collect([]);
    }
    protected function getRoleByUserId($userId)
    {
        $user = User::find($userId);
        return $user ? $user->getRoleNames()->first() : null;
    }

    public function form(Form $form): Form
    {
        $currentUser = Auth::user();
        $currentUserRole = $currentUser->getRoleNames()->first();

        if ($currentUserRole === 'eselon_pembantu_pimpinan') {
            return $form
                ->schema([
                    Section::make('Tujuan Disposisi')
                        ->schema([
                            Forms\Components\CheckboxList::make('disposisi_kepada')
                                ->label('Disposisi Kepada')
                                ->options($this->getUsersByRole())
                                ->required()
                                ->columns(4),
                        ]),
                    Section::make('Detail Disposisi')
                        ->schema([
                            Forms\Components\Textarea::make('isi')
                                ->label('Uraian Disposisi'),
                            Forms\Components\Hidden::make('user_id')
                                ->default(Auth::user()->id)
                                ->required(),
                            Forms\Components\DatePicker::make('tanggal_disposisi')
                                ->required()
                                ->label('Tanggal Disposisi')
                                ->default(now()),
                            SignaturePad::make('paraf')
                                ->label(__('Paraf disini'))
                                ->exportPenColor('#000')
                                ->penColor('#000')
                                ->penColorOnDark('#fff')
                                ->exportPenColor('#00f'),
                        ])->columns(2),
                ])
                ->columns(1);
        }
        return $form
            ->schema([
                Section::make('Tujuan Disposisi')
                    ->schema([
                        Forms\Components\CheckboxList::make('disposisi_kepada')
                            ->label('Disposisi Kepada')
                            ->options($this->getUsersByRole())
                            ->required()
                            ->columns(4),
                        Forms\Components\CheckboxList::make('disposisi_list_id')
                            ->label('Disposisi')
                            ->options(DisposisiList::all()->pluck('ur_disposisi_list', 'id'))
                            ->required()
                            ->columns(4),
                    ]),
                Section::make('Detail Disposisi')
                    ->schema([
                        Forms\Components\Textarea::make('isi')
                            ->label('Uraian Disposisi'),
                        Forms\Components\Hidden::make('user_id')
                            ->default(Auth::user()->id)
                            ->required(),
                        Forms\Components\DatePicker::make('tanggal_disposisi')
                            ->required()
                            ->label('Tanggal Disposisi')
                            ->default(now()),
                        SignaturePad::make('paraf')
                            ->label(__('Paraf disini'))
                            ->exportPenColor('#000')
                            ->penColor('#000')
                            ->penColorOnDark('#fff')
                            ->exportPenColor('#00f'),
                        // Forms\Components\Textarea::make('catatan')
                        //     ->label('Catatan')
                    ])->columns(2),
            ])
            ->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nomor_agenda')
            ->columns([
                Tables\Columns\TextColumn::make('user.jabatan')
                    ->label('Disposisi Dari'),
                Tables\Columns\TextColumn::make('penerimaDisposisi')
                    ->label('Penerima Disposisi')
                    ->badge(),
                Tables\Columns\TextColumn::make('isi')
                    ->label('Isi Disposisi')->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_disposisi')
                    ->label('Tanggal Disposisi')
                    ->sortable()
                    ->searchable()
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(
                        function ($record, $data) {
                            foreach ($data['disposisi_kepada'] as $kepada) {
                                Notification::make()
                                    ->title(__('notifications.new_disposisi'))
                                    ->icon('heroicon-o-document-check')
                                    ->body(
                                        "<b>" . __('notifications.number_agenda') . ":</b> {$record->suratMasuk->nomor_agenda} <br>".
                                        "<b>" . __('notifications.subject') . ":</b> {$record->suratMasuk->perihal} <br>"
                                    )
                                    ->actions([
                                        Action::make(__('notifications.view'))
                                            ->url(SuratMasukResource::getUrl('edit', ['record' => $record->surat_masuk_id]))->markAsRead(),
                                    ])
                                    ->success()
                                    ->sendToDatabase(User::find($kepada));
                            }
                        }
                    ),
            ])
            ->actions([
                Tables\Actions\Action::make('print')
                    ->label('')
                    ->color('primary')
                    ->icon('heroicon-o-printer')
                    ->url(function ($record) {
                        $userRole = $this->getRoleByUserId($record->user_id);
                        return $userRole === 'eselon_pembantu_pimpinan'
                            ? route('disposisi.print_v2', $record)
                            : route('disposisi.print', $record);
                    }, shouldOpenInNewTab: true),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
