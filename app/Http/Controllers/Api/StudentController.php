<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentEditResource;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        if($students->count()>0){

            return StudentResource::collection($students);

        
    }else{
        return response()->json([
            'status' => 404,
            'Status_message' => 'No Records Found'
        ],404);

    }
    }
    public function show($id)
    {
        $student = Student ::find($id);
        if($student){
            return StudentEditResource::make($student);


        }else{
            return response()->json([
                'status' => 404,
                'Status_message' => 'No such student Found'
            ],404);

        }
    }
    public function store(Request $request)
    {
        $validator  = Validator::make($request->all(),[
            'name' =>'required|string|max:191',
            'course' =>'required|string|max:191',
            'email' =>'required|email|max:191',
            'phone' =>'required|digits:10',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages()

            ],422);
        }else{
            $student =Student::create([
                'name'=>$request-> name,
                'course'=>$request-> course,
                'email'=>$request-> email,
                'phone'=>$request-> phone,
            ]);
            if($student){
                return response()->json([
                    'status' => 200,
                    'message' => "Student Created Sucessfully"
                ],200);
         

            }else{

                return response()->json([
                    'status' => 500,
                    'message' => "Something went wrong"
                ],500);

            }



        }

    }

    public function edit($id){

        $students = Student::all();
        if($students->count()>0){

            return StudentEditResource::collection($students);
        }
    else{
            return response()->json([
                'status' => 404,
                'Status_message' => 'No such student Found'
            ],404);

        }

    }

    public  function update( Request $request,int $id){
    {

        $validator  = Validator::make($request->all(),[
            'name' =>'required|string|max:191',
            'course' =>'required|string|max:191',
            'email' =>'required|email|max:191',
            'phone' =>'required|digits:10',
        ]);
        

        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages()

            ],422);
        }else{
            $student =Student::find($id);
            if($student){
                $student->update([
                    'name'=>$request-> name,
                    'course'=>$request-> course,
                    'email'=>$request-> email,
                    'phone'=>$request-> phone,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Student updated Sucessfully"
                ],200);

            }else{

                return response()->json([
                    'status' => 404,
                    'message' => "No such student found!"
                ],404);

            }



        }


    }
}
public function destroy($id)
{
    $student = Student::find($id);
    if($student){
       $student->delete();
       return response()->json([
        'status' => 200,
        'message' => "Student Deleted Sucessfully"
    ],200);

    }else{
        return response()->json([
            'status' => 404,
            'message' => "No such student found!"
        ],404);

    }
}
}