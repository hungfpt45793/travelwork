<?php

namespace App\Http\Controllers\Site;

use App\Entity\Educate_categories;
use App\Entity\Educate_class;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EducateCategoriesController extends SiteController
{
    public function list_edu_categories(Request $request)
    {
        $list_edu_categories = new Educate_categories();
        $list_edu_categories = $list_edu_categories->select('*')
            ->orderBy('edu_cate_id','desc')
            ->get();
        return view('site.educate.list_edu_categories',compact('list_edu_categories'));
    }
    public function edu_categories(Request $request,$slug)
    {
        $edu_categories = new Educate_categories();
        $edu_categories = $edu_categories->select('edu_cate_id','edu_cate_slug','edu_cate_title','edu_cate_content')
            ->where('edu_cate_slug',$slug)
            ->first();
        $list_edu_class = new Educate_class();
        $list_edu_class = $list_edu_class->select('*')
            ->whereDate('edu_date_end', '>=', date('Y-m-d'))
            ->where('edu_cate_id',$edu_categories->edu_cate_id)
            ->paginate(12);
//        echo '<pre>';
//        print_r($edu_categories);die;
        return view('site.educate.edu_categories',compact('edu_categories','list_edu_class'));

    }
}
