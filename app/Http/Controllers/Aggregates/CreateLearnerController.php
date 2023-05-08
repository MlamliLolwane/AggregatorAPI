<?php

namespace App\Http\Controllers\Aggregates;

use Illuminate\Http\Request;
use Illuminate\Http\Client\Pool;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class CreateLearnerController extends Controller
{
    public function create_learner(Request $request)
    {
        $learner = Http::learnerinfoapi()->post('store', $request->learner_information);

        $learner_id = $learner['id'];

        $grade_learner = $request->grade_learner;
        $contacts = $request->contacts;
        
        $grade_learner['learner_id'] = $learner_id;
        $contacts['learner_id'] = $learner_id;

        Http::pool(fn (Pool $pool) => [
            $pool->as('grade_learners')->post('http://localhost:8002/api/grade_learner/store', $grade_learner),
            $pool->as('contacts')->post('http://localhost:8001/api/contacts/store', $contacts)
        ]);

        //If all the requests were successful

        //If one or more requests were unsuccessful rollback the transactions

        return response()->json('Learner created successfully', Response::HTTP_CREATED);
    }
}
