<?php

namespace App\Http\Controllers\Aggregates;

use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Traits\PaginatorTrait;

class LearnerDetailedInformation extends Controller
{
    use PaginatorTrait;
    //Get the names, grades and contact details of the learners
    public function learner_information()
    {
        $responses = Http::pool(fn (Pool $pool) => [
            $pool->as('contacts')->get('http://localhost:8001/api/contacts/index'),
            $pool->as('grades')->get('http://localhost:8002/api/grade/index'),
            $pool->as('learners')->get('http://localhost:8003/api/learners/index'),
            $pool->as('grade_learner')->get('http://localhost:8002/api/grade_learner/index'),
        ]);

        $index = 0;
        $learners_info = array();

        /**
         * Outer loop has to be that of the grades
         */
        
        foreach ($responses['grades']['data'] as $grades) {
            $index = 0;
            foreach ($responses['learners']['data'] as $learner) {
                if ($learner['id'] == $responses['grade_learner']['data'][$index]['learner_id']) {
                    $id = $learner['id'];
                    $first_name = $learner['first_name'];
                    $last_name = $learner['last_name'];
                    $grade = $grades['grade_number']
                        . $grades['grade_suffix'];
                }

                //Match the learner information to the contacts
                if ($learner['contact_id'] == $responses['contacts']['data'][$index]['id']) {
                    $cellphone = $responses['contacts']['data'][$index]['cell_phone'];
                    $whatsapp = $responses['contacts']['data'][$index]['whatsapp'];
                    $email = $responses['contacts']['data'][$index]['email'];
                }

                //Aggregate the results to the learner_info array
                array_push($learners_info, [
                    'id' => $id,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'grade' => $grade,
                    'cellphone' => $cellphone,
                    'whatsapp' => $whatsapp,
                    'email' => $email
                ]);
                $index++;
            }
        }

        return response()->json($this->paginate($learners_info), Response::HTTP_OK);
    }
}
