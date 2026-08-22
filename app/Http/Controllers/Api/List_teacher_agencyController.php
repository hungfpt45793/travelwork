<?php

namespace App\Http\Controllers\Api;

use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\EmployerRepresentative;
use App\Entity\Invite;
use App\Entity\Job;
use App\Entity\List_teacher_agency;
use App\Entity\User;
use App\Http\Controllers\Site\MailConfigController;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class List_teacher_agencyController extends Controller
{
    public function update_teacher_agency(Request $request)
    {
        $teacher_agen = new List_teacher_agency();
        $check_email = $teacher_agen->where('teacher_email', $request->teacher_email)->count();
        if ($check_email > 0) {
            $update_agen = $teacher_agen->where('teacher_email', $request->teacher_email)->update([
                'teacher_id' => $request->input('teacher_id'),
                'teacher_name' => $request->input('teacher_name'),
                'teacher_slug' => $request->input('slug'),
                'local_area' => $request->input('local_area'),
                'province' => $request->input('province'),
                'district' => $request->input('district'),
                'updated_at' => new \DateTime(),
            ]);
            $update = $teacher_agen->where('teacher_email', $request->input('teacher_email'))->update([
                'teacher_min' => $request->input('teacher_min'),
                'updated_at' => new \DateTime(),
            ]);
        } else {
            $inert = $teacher_agen->insertGetId([
                'teacher_id' => $request->input('teacher_id'),
                'teacher_name' => $request->input('teacher_name'),
                'teacher_email' => $request->input('teacher_email'),
                'teacher_slug' => $request->input('slug'),
                'local_area' => $request->input('local_area'),

                'province' => $request->input('province'),
                'district' => $request->input('district'),
                'updated_at' => new \DateTime(),
            ]);
            $update = $teacher_agen->where('teacher_email', $request->input('teacher_email'))->update([
                'teacher_min' => $request->input('teacher_min'),
                'updated_at' => new \DateTime(),
            ]);
        }
        return true;
    }

}
