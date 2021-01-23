<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGradeRequest;
use App\Models\Grade;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grades = Grade::orderByDesc('id')->paginate(10);
        return view("Grades.index", compact("grades"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Grades.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreGradeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGradeRequest $request)
    {
        $studentName = $request->input("studentName");
        $grade1 = $request->input("grade1");
        $grade2 = $request->input("grade2");
        $grade3 = $request->input("grade3");
        $finalGrade = $this->calculateFinalGrade($grade1, $grade2, $grade3);

        try {
            DB::beginTransaction();

            Grade::create([
                "student_name" => $studentName,
                "grade_1"      => $grade1,
                "grade_2"      => $grade2,
                "grade_3"      => $grade3,
                "final_grade"  => $finalGrade
            ]);

            DB::commit();
            return redirect()->route("grades_index")->with("info", "Calificación almacenada.");
        } catch (\Exception $e) {
            DB::rollBack();
            abort(500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $grade = Grade::findOrFail($id);
        return view("Grades.edit", compact("grade"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreGradeRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreGradeRequest $request, $id)
    {
        $grade = Grade::findOrFail($id);
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
            return redirect()->route("grades_index")->with("info", "Calificación modificada.");
        } catch (\Exception $e) {
            DB::rollBack();
            abort(500);
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
        try {
            DB::beginTransaction();
            Grade::destroy($id);
            DB::commit();
            return redirect()->route("grades_index")->with("info", "Calificación eliminada.");
        } catch (\Exception $e) {
            DB::rollBack();
            abort(500);
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
}
