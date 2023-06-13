<?php

namespace App\Http\Controllers\Aggregates;

use Illuminate\Http\Response;
use App\Traits\PaginatorTrait;
use Illuminate\Http\Client\Pool;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class GetNewsletters extends Controller
{
    use PaginatorTrait;

    public function get_newsletters()
    {
        $responses = Http::pool(fn (Pool $pool) => [
            $pool->as('newsletters')->get('http://localhost:8004/api/newsletters/index'),
            $pool->as('grades')->get('http://localhost:8002/api/grade/index'),
        ]);

        $aggregated_newsletter = array();
        $grades = array();

        foreach ($responses['newsletters']['data'] as $newsletter) {
            $newsletter_grade_ids = explode(',', $newsletter['grade_ids']);

            foreach ($newsletter_grade_ids as $newsletter_grade_id) {
                foreach ($responses['grades']['data'] as $grade) {
                    if ($newsletter_grade_id == $grade['id']) {
                        array_push($grades, $grade['grade_number'] . $grade['grade_suffix'] . ' ');
                        break;
                    }
                }
            }
            array_push($aggregated_newsletter, (object) [
                'id' => $newsletter['id'],
                'title' => $newsletter['title'],
                'created_at' => $newsletter['created_at'],
                'grades' => implode(",", $grades)
            ]);
            $grades = array();
        }

        return response()->json($aggregated_newsletter, Response::HTTP_OK);
    }
}
