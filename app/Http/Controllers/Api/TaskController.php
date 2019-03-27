<?php

namespace App\Http\Controllers\Api;

use App\Http\Helpers\CompanyManager;
use App\Http\Helpers\TaskHelper;
use App\Http\Requests\StoreTask;
use App\Http\Requests\UpdateTask;
use App\Models\Task;
use App\Models\User;
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
        $this->middleware("Before")->except('index', 'store');
        $this->middleware("Before:restrictEmployee")->only('show');
        $this->middleware("Before:bossesCan")->except('show');
        $this->middleware("Before:controlEmployeeAssignment")->only('update', 'store');
    }

    public function controlEmployeeAssignment(Request $request)
    {
        $company = CompanyManager::getInstance()->retrieve('company');
        if($employees = $request->input('employees')) {
            return $company->canCompanyManageTask($employees);
        }
        return true;
    }

    public function bossesCan()
    {
        $user = CompanyManager::getInstance()->retrieve('user');
        if($user->isBoss()) {
            return true;
        }
    }

    public function restrictEmployee(Request $request)
    {
        $task = $request->route('task');
        $user = CompanyManager::getInstance()->retrieve('user');
        $taskForUser = $user->tasks;
        if($user->isEmployee()) {
            if($taskForUser->contains($task->id)) {
                return true;
            }
        } else if($user->isBoss()) return true;
    }

    public function before(Request $request)
    {
        if($task = $request->route('task')) {
            return $task->isTaskFromCompany(CompanyManager::getInstance()->retrieve('company'));
        }
    }

    public function index()
    {
        return $this->helper->index();
    }

    public function show(Task $task)
    {
        return $this->helper->show($task);
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
