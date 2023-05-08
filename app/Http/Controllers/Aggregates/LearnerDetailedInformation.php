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
    public function get_last_learner_information()
    {
        $responses = Http::pool(fn (Pool $pool) => [
            $pool->as('contacts')->get('http://localhost:8001/api/contacts/last_contact'),
            $pool->as('learners')->get('http://localhost:8003/api/learners/last_learner'),
            $pool->as('grade_learner')->get('http://localhost:8002/api/grade_learner/last_grade_learner')
        ]);

        return response()->json([
            'contact' => $responses['contacts']['data'],
            'learner' => $responses['learners']['data'], 
            'grade_learner' => $responses['grade_learner']['data']
        ]);
    }
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

        //return response($responses['grade_learner']['data']);

        /**
         * Outer loop has to be that of the grades
         */

        //There is no way grade learners can be less than learners. They have to be exactly the same size
        // The below algorithm is wrong
        $id = '';
        $first_name = '';
        $last_name = '';
        $grade = '';
        $cellphone = '';
        $whatsapp = '';
        $email = '';

        //return response($responses['grades']);

        foreach ($responses['grades']['data'] as $grades) {
            $index = 0;
            foreach ($responses['grade_learner']['data'] as $grade_learner) {
                if ($grades['id'] == $grade_learner['grade_id']) {
                    $id = $responses['learners']['data'][$index]['id'];
                    $first_name = $responses['learners']['data'][$index]['first_name'];
                    $last_name = $responses['learners']['data'][$index]['last_name'];
                    $grade = $grades['grade_number']
                        . $grades['grade_suffix'];

                    $cellphone = $responses['contacts']['data'][$index]['cell_phone'];
                    $whatsapp = $responses['contacts']['data'][$index]['whatsapp'];
                    $email = $responses['contacts']['data'][$index]['email'];

                    array_push($learners_info, [
                        'id' => $id,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'grade' => $grade,
                        'cellphone' => $cellphone,
                        'whatsapp' => $whatsapp,
                        'email' => $email
                    ]);
                }

                //     //Match the learner information to the contacts
                // if ($learner['contact_id'] == $responses['contacts']['data'][$index]['id']) {
                //     $cellphone = $responses['contacts']['data'][$index]['cell_phone'];
                //     $whatsapp = $responses['contacts']['data'][$index]['whatsapp'];
                //     $email = $responses['contacts']['data'][$index]['email'];
                // }

                //     //Aggregate the results to the learner_info array

                $index++;
                // }
            }
        }

        return response()->json($this->paginate($learners_info), Response::HTTP_OK);
    }
}
