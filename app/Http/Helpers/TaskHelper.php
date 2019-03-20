<?php

namespace App\Http\Helpers;


use App\Http\Requests\StoreTask;
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

    public function index(Request $request)
    {
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
            throw new UnprocessableEntityHttpException("Bad request");
        }

    }

    public function show(Task $task)
    {

    }

    public function update(Task $task, Request $request)
    {

    }

    public function destroy(Task $task)
    {

    }


}