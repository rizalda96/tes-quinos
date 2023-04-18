<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    protected $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function search(Request $request)
    {
        $query = $this->student->get();

        return $this->redirectResponse($request, 'success', 'success', $query);
    }

    public function store(Request $request)
    {
        $res = $this->student->create([
            'code' => $request->code,
            'nama' => $request->fullname,
            'telp' => $request->telp,
            'kota' => $request->kota,
        ]);

        return $this->redirectResponse($request, 'success', 'success', $res);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $data = Student::where('id', $id['id']);
        $query = $data->update([
            'code' => $request->code,
            'nama' => $request->fullname,
            'telp' => $request->telp,
            'kota' => $request->kota,
        ]);

        return $this->redirectResponse($request, 'success', 'success', $query);
    }

    public function show(Request $request)
    {
        $query = $this->student->where('id', $request->id)->first();

        return $this->redirectResponse($request, 'success', 'success', $query);
    }

    public function validateCode(Request $request)
    {
        // dd($request->code);
        $query = $this->student->where('code', $request->code)->first();

        if ($query) {
            return response()->json(
                [
                    'valid' => false,
                    'data' => ['message' => $request->type . ' already exist.']
                ]
            );
        }

        return response()->json(
            [
                'valid' => true,
                'data' => ['message' => $request->type . ' can be use']
            ]
        );
    }

    public function drop(Request $request)
    {
        $deleted = $this->student->where(['id' => $request->id])->delete();
        $type = !$deleted ? 'error' : 'success';

        return $this->redirectResponse($request, $type, $type, $deleted);
    }
}
