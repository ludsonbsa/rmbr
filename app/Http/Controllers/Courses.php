<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

use App\Http\Requests;

class Courses extends Controller
{


    public function index(Request $request){
        $str = $request->get('str',"");

        if($str){
            //faz busca no nome
            //$courses = Course::where('name','like','%'.$str.'%')->orWhere('description','like','%'.$str.'%')->get();

            //Search que vai buscar no algolia através do searchable(trait) inserida no controller
            $courses = Course::search($str)->get();
        }else{
            $courses = Course::all();
        }

        return view('courses.angular', ['courses' => $courses, 'str' => $str]);
    }
}
