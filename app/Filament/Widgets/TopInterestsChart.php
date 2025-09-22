<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TopInterestsChart extends ChartWidget
{
    protected static ?string $heading = 'Top 20 Interests by Number of People';

    protected function getData(): array
    {
        $data = DB::table('interests')
            ->join('person_interest', 'interests.id', '=', 'person_interest.interest_id')
            ->join('people', 'person_interest.person_id', '=', 'people.id')
            ->whereNull('people.deleted_at')
            ->select('interests.name', DB::raw('count(person_interest.person_id) as count'))
            ->groupBy('interests.id', 'interests.name')
            ->orderBy('count', 'desc')
            ->limit(20)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Number of People',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.8)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                ],
            ],
            'labels' => $data->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public function getColumnSpan(): string
    {
        return 'full';
    }
}
