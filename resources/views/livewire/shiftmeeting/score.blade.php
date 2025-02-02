<div>
    {{-- Do your work, then step back. --}}
    {{-- {{ $this->filtersForm() }} --}}
    
    <form wire:submit="filter">
        {{ $this->filtersForm }}
        <x-filament::button type="submit">Submit</x-filament::button>
    </form>
    {{-- {{ json_encode($this->data) }} --}}
    <x-filament-actions::modals />
    {{-- <x-filament-widgets::widgets
    :columns="$this->getColumns()"
    :data="
    [
        ...(property_exists($this, 'filters') ? ['filters' => $this->filters] : []),
        ...$this->getWidgetData(),
        ]
        "
        :widgets="$this->getVisibleWidgets()"
        /> --}}
        @livewire(\App\Filament\Resources\ShiftMeetingResource\Widgets\ShiftmeetingScoreOverview::class)
        {{-- @dd($filters); --}}
    </div>
