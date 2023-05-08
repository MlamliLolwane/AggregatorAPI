<?php

namespace App\Http\Controllers\Aggregates;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use App\Traits\PaginatorTrait;

class UsageStatistics extends Controller
{
    use PaginatorTrait;
    
    public function get_usage_statisctics()
    {
        $responses = Http::pool(fn (Pool $pool) => [
            $pool->as('grades')->get('http://localhost:8002/api/grade/count'),
            $pool->as('learners')->get('http://localhost:8003/api/learners/count'),
            $pool->as('newsletters')->get('http://localhost:8004/api/newsletters/count'),
        ]);

        return response()->json($this->paginate([
            'grades' => $responses['grades']['data'],
            'learners' => $responses['learners']['data'],
            'newsletters' => $responses['newsletters']['data']
        ]));
    }
}
