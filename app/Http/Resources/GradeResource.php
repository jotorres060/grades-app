<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GradeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'student_name' => $this->student_name,
            'grade_1'      => $this->grade_1,
            'grade_2'      => $this->grade_2,
            'grade_3'      => $this->grade_3,
            'final_grade'  => $this->final_grade,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        ];
    }
}
