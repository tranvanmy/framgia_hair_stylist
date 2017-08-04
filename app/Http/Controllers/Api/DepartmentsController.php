<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\DepartmentRepository;
use App\Helpers\Helper;
use App\Eloquents\User;
use Validator;
use Response;
use Auth;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $department;
    protected $selectDepartment = [
        'id',
        'name',
        'address',
    ];

    public function __construct(DepartmentRepository $department)
    {
        $this->department = $department;
    }

    public function index()
    {
        $response = Helper::apiFormat();

        $data = $this->department->getAllData([], $this->selectDepartment);
        
        $response['data'] = $data;

        return Response::json($response) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = Helper::apiFormat();

        $user = Auth::guard('api')->user();
        if (!$user || $user->permission != User::PERMISSION_ADMIN) {
            $response['error'] = true;
            $response['message'][] = __('You do not have permission to perform this action!');
            $response['status'] = 403;

            return Response::json($response, $response['status']);
        }

        $rule = [
            'department_name' => 'required|max:255',
            'department_address' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $response['error'] = true;
            $response['status'] = 403;
            foreach ($rule as $key => $value) {
                $response['message'][] = $validator->messages()->first($key);
            }

            return Response::json($response, 403);
        }
        $getDepartment = $this->department
            ->getDepartmentByAdress($request->department_address);

        if($getDepartment && $request->department_address == $getDepartment->address)
        {
            $response['error'] = true;
            $response['status'] = 403;
            $response['message'] = __('This department already exist!');

            return Response::json($response, 403);
        }

        $departmentData = [
            'name' => $request->department_name,
            'address' => $request->department_address,
        ];

        $departmentCreated = $this->department->create($departmentData);

        $response['data'] = $this->department->find($departmentCreated->id);
        $response['message'][] = __('Create department successfully!');

        return Response::json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = Helper::apiFormat();

        $user = Auth::guard('api')->user();
        if (!$user || $user->permission != User::PERMISSION_ADMIN) {
            $response['error'] = true;
            $response['message'][] = __('You do not have permission to perform this action!');
            $response['status'] = 403;

            return Response::json($response, $response['status']);
        }

        $department = $this->department->find($id);

        if (!$department) {
            $response['error'] = true;
            $response['status'] = 403;
            $response['message'][] = __('Not found department!');

            return Response::json($response);
        }

        $rule = [
            'department_name' => 'required|max:255',
            'department_address' => 'required|string',
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $response['error'] = true;
            $response['status'] = 403;
            foreach ($rule as $key => $value) {
                if ($validator->messages()->first($key)) {
                    $response['message'][] = $validator->messages()->first($key);
                }
            }

            return Response::json($response, $response['status']);
        }
        $dataEdit = [
            'name' => $request->department_name,
            'address' => $request->department_address,
        ];
        try {
            $department->fill($dataEdit)->save();
            $response['message'][] = __('Updated department successfully!');
        } catch (Exception $e) {
            $response['error'] = true;
            $response['status'] = 403;
            $response['message'][] = $e->getMessage();
        }

        return Response::json($response, $response['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
