<?php

namespace App\Http\Helpers;


use App\Http\Requests\StoreTask;
use App\Http\Requests\UpdateTask;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class TaskHelper
{
    protected $model;

    public function __construct()
    {
        $this->model = new Task();
    }

    public function index()
    {
        if(session()->has('user')) {
            $company = session()->get('user')->company;
        } else {
            $company = CompanyManager::getInstance()->retrieve('company');
        }
        return $company->companyTasks();
    }

    public function store(StoreTask $request)
    {
        $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('start_date'));
        $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('end_date'));

        if(($startDate->year < 2038 && $endDate->year < 2038) && ($startDate->year > 1969 && $endDate->year > 1969)) {
            $this->model->name = $request->input('name');
            $this->model->description = $request->input('description');
            $this->model->startDate = $startDate;
            $this->model->endDate = $endDate;
            $this->model->numOfEmployees = $request->input('count');
            $this->model->priority = $request->input('priority');
            $this->model->employees = $request->input('employees');

            return Task::storeTask($this->model->name,
                $this->model->description,
                $this->model->startDate,
                $this->model->endDate,
                $this->model->numOfEmployees,
                $this->model->priority,
                $this->model->employees
            );
        } else {
            throw new UnprocessableEntityHttpException();
        }

    }

    public function show(Task $task)
    {
        return $task->load('taskStatus', 'taskPriority', 'users');
    }

    public function update(Task $task, UpdateTask $request)
    {
        $data = $request->all();
        foreach ($data as $key => $val) {
            if(!$val) {
                unset($data[$key]);
            }
        }
        return $task->updateTask($data);

    }

    public function destroy(Task $task)
    {
        $task->deleteTask();
    }


}