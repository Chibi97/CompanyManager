<?php

namespace App\Http\Controllers\Api;

use App\Http\Helpers\CompanyManager;
use App\Http\Helpers\TaskHelper;
use App\Http\Requests\StoreTask;
use App\Http\Requests\UpdateTask;
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
        $this->middleware("Before")->except('index');
    }

    public function before(Request $request)
    {
        $company = CompanyManager::getInstance()->retrieve('company');
        if($employees = $request->input('employees')) {
            return $company->canCompanyManageTask($employees);
        }

        if($task = $request->route('task')) {
            return $task->isTaskFromCompany($company);
        }
    }

    public function index()
    {
        return $this->helper->index();
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
        return $this->helper->show($task);
    }

    public function update(Task $task, UpdateTask $request)
    {
        try {
            $this->helper->update($task, $request);
            return response(["message" => "Successfully updated task!"], 200);
        } catch(\Exception $e) {
            return response(["error" => "Please provide valid information (especially for status and priority)."],
                400);
        }
    }

    public function destroy(Task $task)
    {
        $this->helper->destroy($task);
        return response(["message" => "Task successfully deleted"], 200);
    }
}
