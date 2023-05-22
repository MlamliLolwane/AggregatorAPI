<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all_grades()
    {
        $response = Http::gradesapi()->get('grade/index');

        return response($response);
    }

    public function distinctGrades()
    {
        $response = Http::gradesapi()->get('grade/distinct');

        return response($response);
    }

    public function index()
    {
        $response = Http::gradesapi()->get('grade/index');

        $grades = array();
        $current_grade = 0;
        $classes = '';
        $grades = array();
        //Check that the response is not null and assign the first index values to current_grade and classes variables
        if (isset($response)) {
            $current_grade = $response['data'][0]['grade_number'];
            $classes = $response['data'][0]['grade_suffix'];
        }

        //Loop through the array comparing grades and then add classes for each grade
        for ($i = 1; $i < count($response['data']); $i++) {
            if ($current_grade == $response['data'][$i]['grade_number']) {
                $classes = $classes . ' , ' . $response['data'][$i]['grade_suffix'];
            } else {
                array_push($grades, (object)[
                    'current_grade' => $current_grade,
                    'classes' => $classes
                ]);

                $current_grade = $response['data'][$i]['grade_number'];
                $classes = $response['data'][$i]['grade_suffix'];
            }
        }

        //Add the last current grade and classes to the array
        array_push($grades, [
            'current_grade' => $current_grade,
            'classes' => $classes
        ]);


        return response()->json($grades);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = Http::gradesapi()->post('grade/store', $request->all());

        return response($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = Http::gradesapi()->get('grade/show/' . $id);

        return response($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = Http::gradesapi()->patch('grade/update/' . $id, $request->all());

        return response($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = Http::gradesapi()->delete('grade/destroy/' . $id);

        return response($response);
    }
}
