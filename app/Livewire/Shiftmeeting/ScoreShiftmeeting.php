<?php

namespace App\Livewire\Shiftmeeting;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Tables\Filters\SelectFilter;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ScoreShiftmeeting extends Component implements HasForms
{

    use HasFiltersForm, InteractsWithForms;

        
    public ?array $data = [];
    //public ?array $filters = ["startDate", "endDate"];
    
    public function mount(): void
    {
        $this->filtersForm->fill();
    }
    

    
    public function filter(): void
    {

        dd($this->filtersForm->getState());
    }

    public function updatedFilters(): void
    {
        //dd($this->filtersForm->getState());
        $this->dispatch('updateFilterScoreShiftmeeting', $this->filtersForm->getState());
    }
    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.shiftmeeting.score');
    }

    public function filtersForm(Form $form): Form
    {
        return $form->schema([
                Section::make()
                ->schema([
                    Select::make('group')
                    ->options([
                            "Grup A" => "Grup A",
                            "Grup B" => "Grup B",
                            "Grup C" => "Grup C",
                            "Grup D" => "Grup D",
                        ]),
                    DatePicker::make('startDate')
                            ->maxDate(now()),
                        DatePicker::make('endDate')
                            ->minDate(fn (Get $get) => $get('startDate') ?: now())
                            ->maxDate(now()),
                    ])->statePath('data')->columns(3)
            ]);
    }

  
}
