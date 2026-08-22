<?php

namespace App\Http\Controllers\Api;

use App\Entity\District;
use App\Entity\Experience;
use App\Entity\Province;
use App\Http\Controllers\Controller;
use Validator;

class ExperienceController extends Controller
{
    public function list_experience()
    {
        try
        {
            $experience = new Experience();
             $list_experience = $experience->select('experience_id',
                 'experience_name'
               )->orderBy('experience_id', 'asc')
                 ->get();

            return response()->json([
                'status' => 200,
                'descript' => 'thành công',
                'list_experience' => $list_experience
            ],200);
        }catch (\Exception $e)
        {
            return response()->json([
                'status' => 400,
                'descript' => 'thất bại',
            ],400);
        }
    }


}
