<?php

namespace App\Http\Controllers\Api;

use App\Http\Helpers\CompanyManager;
use App\Http\Helpers\TaskHelper;
use App\Http\Requests\StoreTask;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class TaskController extends Controller
{
    public $helper;
    public function __construct(TaskHelper $helper)
    {
        $this->helper = $helper;
        $this->middleware("CheckApiToken");
//        $this->middleware("Before");
    }

    public function before(Request $request)
    {
        $userIds = CompanyManager::getInstance()->retrieve('company')->users->pluck('id')->toArray();
        $employees = $request->input('employees');
    }

    public function index()
    {
        //
    }


    public function store(StoreTask $request)
    {
        try {
            $this->helper->store($request);
            $message = "Successfully stored task.";
            $status = 201;
        } catch(UnprocessableEntityHttpException $e) {
            $message = "Bad request. Dates should be between 1970 and 2038.";
            $status = 422;
        }

        return response(["message" => $message], $status);
    }


    public function show(Task $task)
    {
        //
    }

    public function update(Request $request, Task $task)
    {
        //
    }


    public function destroy(Task $task)
    {
        //
    }
}
