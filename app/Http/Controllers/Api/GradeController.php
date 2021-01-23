<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Resources\GradeCollection;
use App\Http\Resources\GradeResource;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grades = Grade::orderByDesc('id')->get();
        return response([
            "grades" => new GradeCollection($grades)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validateRequest($request);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 200);
        }

        $studentName = $request->input("studentName");
        $grade1 = $request->input("grade1");
        $grade2 = $request->input("grade2");
        $grade3 = $request->input("grade3");
        $finalGrade = $this->calculateFinalGrade($grade1, $grade2, $grade3);

        try {
            DB::beginTransaction();

            $grade = Grade::create([
                "student_name" => $studentName,
                "grade_1"      => $grade1,
                "grade_2"      => $grade2,
                "grade_3"      => $grade3,
                "final_grade"  => $finalGrade
            ]);

            DB::commit();

            return response([
                'grade' => new GradeResource($grade)
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response([
                'code' => 500,
                'errors' => [
                    'message' => 'Internal Server Error.'
                ]
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $this->validateRequest($request);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 200);
        }

        $grade = Grade::find($id);
        if (!$grade) {
            return response([
                'code' => 404,
                'errors' => [
                    'message' => 'Grade not found.'
                ]
            ], 404);
        }

        $studentName = $request->input("studentName");
        $grade1 = $request->input("grade1");
        $grade2 = $request->input("grade2");
        $grade3 = $request->input("grade3");
        $finalGrade = $this->calculateFinalGrade($grade1, $grade2, $grade3);

        try {
            DB::beginTransaction();

            $grade->update([
                "student_name" => $studentName,
                "grade_1"      => $grade1,
                "grade_2"      => $grade2,
                "grade_3"      => $grade3,
                "final_grade"  => $finalGrade
            ]);

            DB::commit();

            return response([
                'grade' => new GradeResource($grade)
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response([
                'code' => 500,
                'errors' => [
                    'message' => 'Internal Server Error.'
                ]
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grade = Grade::find($id);
        if (!$grade) {
            return response([
                'code' => 404,
                'errors' => [
                    'message' => 'Grade not found.'
                ]
            ], 404);
        }

        try {
            DB::beginTransaction();
            $grade->delete();
            DB::commit();

            return response([
                'grade' => new GradeResource($grade)
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response([
                'code' => 500,
                'errors' => [
                    'message' => 'Internal Server Error.'
                ]
            ], 500);
        }
    }

    /**
     * Calculate the final grade.
     *
     * @param float $grade1
     * @param float $grade2
     * @param float $grade3
     * @return float
     */
    private function calculateFinalGrade(float $grade1, float $grade2, float $grade3): float
    {
        $sum = ($grade1 + $grade2 + $grade3);
        $finalGrade = round(($sum / 3), 1);
        return $finalGrade;
    }

    /**
     * Validate the request.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validateRequest(Request $request)
    {
        $data = $request->all();
        return Validator::make($data, [
            "studentName" => ["required","string","max:255","regex:/^[a-zA-Z\s]*$/"],
            "grade1"      => "required|numeric|between:1,5",
            "grade2"      => "required|numeric|between:1,5",
            "grade3"      => "required|numeric|between:1,5"
        ]);
    }
}
