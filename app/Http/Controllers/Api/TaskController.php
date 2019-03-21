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
        $this->middleware("Before")->except('index');
    }

    public function before(Request $request)
    {
        $company = CompanyManager::getInstance()->retrieve('company');
        if($employees = $request->input('employees')) {
            return $company->canCompanyAddTask($employees);
        }

        if($task = $request->route('task')) {
            return $task->isTaskFromCompany($company);
        }
        return false;
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

    public function update(Task $task, Request $request)
    {
        $this->helper->update($task, $request);
        return response(["message" => "Updated!"], 200);
    }

    public function destroy(Task $task)
    {
        //
    }
}
