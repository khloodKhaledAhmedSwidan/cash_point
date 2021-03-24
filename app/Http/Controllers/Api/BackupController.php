<?php

namespace App\Http\Controllers\Api;

use App\Backup;
use App\ClassNote;
use App\Student;
use App\StudentClass;
use App\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class BackupController extends Controller
{
    /**
     *  Create Backup
     * @create_backup
    */
    public function create_backup(Request $request)
    {
        $rules = [
            'backup_date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

        // create backup
        $backup = Backup::create([
            'back_up_date'  => $request->backup_date
        ]);

        $success = [];
        array_push($success , [
            'id'         => intval($backup->id),
            'backup_date'=> $backup->back_up_date->format('Y-m-d'),
            'created_at' => $backup->created_at->format('Y-m-d'),
        ]);
        return $backup
            ? ApiController::respondWithSuccess($success)
            : ApiController::respondWithServerErrorObject();
    }

    public function get_backups()
    {
        $backups = Backup::orderBy('id' , 'desc')->get();
        $success = [];
        if ($backups->count() > 0)
        {
            foreach ($backups as $backup)
            {
                array_push($success , [
                    'id'         => intval($backup->id),
                    'backup_date'=> $backup->back_up_date->format('Y-m-d'),
                    'created_at' => $backup->created_at->format('Y-m-d'),
                ]);
            }
            return $backups
                ? ApiController::respondWithSuccess($success)
                : ApiController::respondWithServerErrorObject();
        }else{
            $errors = ['key'=>'get_backups',
                'value'=> trans('لا يوجد ')
            ];
            return ApiController::respondWithErrorClient(array($errors));
        }

    }

    /**
     * @store backup data
     * @store_backup_data
    */
    public function store_backup_data(Request $request , $id)
    {
        $rules = [
            'class_id' => 'required',
            'class_name' => 'required',
            'student_id' => 'required',
            'student_name' => 'required',
            'phone' => 'required',
            'image' => 'required',
            'subject_id' => 'required',
            'subject_name' => 'required',
            'note_id' => 'required',
            'note' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

        $backup = Backup::find($id);
        if ($backup)
        {
            // 1- create class
            $check = StudentClass::whereClass_id($request->class_id)->first();
            if ($check == null)
            {
                StudentClass::create([
                    'back_up_id' => $id,
                    'class_id'   => $request->class_id,
                    'class_name' => $request->class_name,
                ]);
            }

            // 2- create class students
            $class = StudentClass::where('back_up_id' , $id)
                ->where('class_id' , $request->class_id)
                ->first();
            $student = Student::create([
                'class_id'   => $class->id,
                'student_id' => $request->student_id,
                'user_id'    => $request->user()->id,
                'name'       => $request->student_name,
                'phone'      => $request->phone,
                'image'      => $request->image,
            ]);
            // 3- create subjects
            $subject = Subject::create([
                'class_id'   => $class->id,
                'subject_id' => $request->subject_id,
                'user_id'    => $request->user()->id,
                'name'       => $request->subject_name,
            ]);
            // create notes
            $note = ClassNote::create([
                'class_id'   => $class->id,
                'note_id'     => $request->note_id,
                'student_id'  => $student->id,
                'subject_id' => $subject->id,
                'note'       => $request->note,
            ]);
            $data = [];
            $students = [];
            array_push($students , [
                'class_id'   => intval($student->class_id),
                'student_id' => intval($student->student_id),
                'user_id'    => intval($student->user_id),
                'name'       => $student->name,
                'phone'      => $student->phone,
                'image'      => $student->image,
                'created_at' => $student->created_at->format('Y-m-d'),
            ]);
            $subjects = [];
            array_push($subjects , [
                'class_id'   => intval($subject->class_id),
                'subject_id' => intval($subject->subject_id),
                'user_id'    => intval($subject->user_id),
                'name'       => $subject->name,
                'created_at' => $subject->created_at->format('Y-m-d'),
            ]);
            $notes = [];
            array_push($notes , [
                'note_id'     => intval($note->note_id),
                'student_id'  => intval($note->student_id),
                'subject_id ' => intval($note->subject_id),
                'note '       => $note->note,
                'created_at'  => $note->created_at->format('Y-m-d'),
            ]);
            array_push($data , [
                'back_up_id' => intval($class->back_up_id),
                'class_id'   => intval($class->class_id),
                'class_name' => $class->class_name,
                'created_at' => $class->created_at->format('Y-m-d'),
                'students'   => $students,
                'subjects'   => $subjects,
                'notes'      => $notes,
            ]);
            return $backup
                ? ApiController::respondWithSuccess($data)
                : ApiController::respondWithServerErrorObject();
        }else{
            $errors = ['key'=>'store_backup_data',
                'value'=> 'backup id  not found'
            ];
            return ApiController::respondWithErrorClient(array($errors));
        }
    }
    public function create_class(Request $request , $backup_id)
    {
        $rules = [
            'class_id' => 'required',
            'class_name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

        $backup = Backup::find($backup_id);
        if ($backup)
        {
            // 1- create class
            $check = StudentClass::whereClass_id($request->class_id)->first();
            if ($check == null)
            {
                StudentClass::create([
                    'back_up_id' => $backup_id,
                    'class_id'   => $request->class_id,
                    'class_name' => $request->class_name,
                ]);
                $data = [];
                $class = StudentClass::where('back_up_id' , $backup_id)
                    ->where('class_id' , $request->class_id)
                    ->first();
                array_push($data , [
                    'back_up_id' => intval($class->back_up_id),
                    'class_id'   => intval($class->class_id),
                    'class_name' => $class->class_name,
                    'created_at' => $class->created_at->format('Y-m-d'),
                ]);
                return $backup
                    ? ApiController::respondWithSuccess($data)
                    : ApiController::respondWithServerErrorObject();
            }else{
                $errors = ['key'=>'create_class',
                    'value'=> 'this class are created before'
                ];
                return ApiController::respondWithErrorClient($errors);
            }
        }else{
            $errors = ['key'=>'create_class',
                'value'=> 'backup id  not found'
            ];
            return ApiController::respondWithErrorClient($errors);
        }
    }
    public function create_student(Request $request , $class_id)
    {
        $rules = [
            'student_id' => 'required',
            'student_name' => 'required',
            'phone' => 'required',
            'image' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));
        $class = StudentClass::whereClass_id($class_id)->first();
        if ($class)
        {
            $student = Student::create([
                'class_id'   => $class->id,
                'student_id' => $request->student_id,
                'user_id'    => $request->user()->id,
                'name'       => $request->student_name,
                'phone'      => $request->phone,
                'image'      => $request->image,
            ]);
            $students = [];
            array_push($students , [
                'class_id'   => intval($student->class->class_id),
                'student_id' => intval($student->student_id),
                'user_id'    => intval($student->user_id),
                'name'       => $student->name,
                'phone'      => $student->phone,
                'image'      => $student->image,
                'created_at' => $student->created_at->format('Y-m-d'),
            ]);
            return $class
                ? ApiController::respondWithSuccess($students)
                : ApiController::respondWithServerErrorObject();
        }else{
            $errors = ['key'=>'create_student',
                'value'=> 'class id  not found'
            ];
            return ApiController::respondWithErrorClient($errors);
        }

    }
    public function create_subject(Request $request , $class_id)
    {
        $rules = [
            'subject_id' => 'required',
            'subject_name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

        $class = StudentClass::whereClass_id($class_id)->first();
        if ($class)
        {
            // 3- create subjects
            $subject = Subject::create([
                'class_id'   => $class->id,
                'subject_id' => $request->subject_id,
                'user_id'    => $request->user()->id,
                'name'       => $request->subject_name,
            ]);
            $subjects = [];
            array_push($subjects , [
                'class_id'   => intval($subject->class->class_id),
                'subject_id' => intval($subject->subject_id),
                'user_id'    => intval($subject->user_id),
                'name'       => $subject->name,
                'created_at' => $subject->created_at->format('Y-m-d'),
            ]);
            return $class
                ? ApiController::respondWithSuccess($subjects)
                : ApiController::respondWithServerErrorObject();
        }else{
            $errors = ['key'=>'create_subject',
                'value'=> 'class id  not found'
            ];
            return ApiController::respondWithErrorClient($errors);
        }
    }
    public function get_backup_data($id){
        $backup = Backup::find($id);
        if ($backup)
        {
            $classes = StudentClass::where('back_up_id' , $id)
                ->orderBy('id' , 'desc')
                ->get();
            $students_arr = [];
            $subjects_arr = [];
            $notes_arr = [];
            $data = [];
            if ($classes->count() > 0)
            {
                foreach ($classes as $class)
                {
                    $students = Student::whereClass_id($class->id)->get();
                    foreach ($students as $student)
                    {
                        array_push($students_arr , [
                            'class_id'   => intval($student->class->class_id),
                            'student_id' => intval($student->student_id),
                            'user_id'    => intval($student->user_id),
                            'name'       => $student->name,
                            'phone'      => $student->phone,
                            'image'      => $student->image,
                            'created_at' => $student->created_at->format('Y-m-d'),
                        ]);
                    }
                    $subjects = Subject::whereClass_id($class->id)->get();
                    foreach ($subjects as $subject)
                    {
                        array_push($subjects_arr , [
                            'class_id'   => intval($subject->class->class_id),
                            'subject_id' => intval($subject->subject_id),
                            'user_id'    => intval($subject->user_id),
                            'name'       => $subject->name,
                            'created_at' => $subject->created_at->format('Y-m-d'),
                        ]);
                    }
//                    $notes = ClassNote::whereClass_id($class->id)->get();
//                    foreach ($notes as $note)
//                    {
//                        array_push($notes_arr , [
//                            'note_id'     => intval($note->note_id),
//                            'student_id'  => intval($note->student_id),
//                            'subject_id ' => intval($note->subject_id),
//                            'note '       => $note->note,
//                            'created_at'  => $note->created_at->format('Y-m-d'),
//                        ]);
//                    }
                    array_push($data , [
                        'back_up_id' => intval($class->back_up_id),
                        'class_id'   => intval($class->class_id),
                        'class_name' => $class->class_name,
                        'created_at' => $class->created_at->format('Y-m-d'),
                        'students'   => $students->count() > 0 ? $students_arr : null,
                        'subjects'   => $subjects->count() > 0 ? $subjects_arr : null,
//                        'notes'      => $notes_arr,
                    ]);
                }

                return $backup
                    ? ApiController::respondWithSuccess($data)
                    : ApiController::respondWithServerErrorObject();
            }else{
                $errors = ['key'=>'get_backup_data',
                    'value'=> 'No Classes Found'
                ];
                return ApiController::respondWithErrorClient(array($errors));
            }
        }else{
            $errors = ['key'=>'get_backup_data',
                'value'=> 'backup id  not found'
            ];
            return ApiController::respondWithErrorClient(array($errors));
        }
    }
}
