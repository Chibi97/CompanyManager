<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

class TaskManageTest extends TestCase
{
    private $company1;
    private $company2;

    private $company1Boss;
    private $company2Boss;
    private $company1Employee;

    private $boss1Task;
    private $boss2Task;
    private $employee1Task;

    public function setUp()
    {
        parent::setUp();
        $company1 = factory(Company::class)->create();
        $company2 = factory(Company::class)->create();

        $company1Boss = factory(User::class)->make();
        $company1Boss->role_id = 1;
        $company1Boss->user_status_id = 1;
        $company1Boss->company_id = $company1->id;
        $company1Boss->save();

        $company1Employee = factory(User::class)->make();
        $company1Employee->role_id = 2;
        $company1Employee->user_status_id = 1;
        $company1Employee->company_id = $company1->id;
        $company1Employee->save();

        $company2Boss = factory(User::class)->make();
        $company2Boss->role_id = 1;
        $company2Boss->user_status_id = 1;
        $company2Boss->company_id = $company2->id;
        $company2Boss->save();

        $boss1Task = factory(Task::class)->make();
        $boss1Task->task_priority_id = 1;
        $boss1Task->task_status_id = 1;
        $boss1Task->save();

        $boss1Task->users()->attach($company1Boss,
            [
                "is_accepted" => rand(0,1),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);

        $employee1Task = factory(Task::class)->make();
        $employee1Task->task_priority_id = 1;
        $employee1Task->task_status_id = 1;
        $employee1Task->save();

        $employee1Task->users()->attach($company1Boss,
            [
                "is_accepted" => rand(0,1),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);

        $boss2Task = factory(Task::class)->make();
        $boss2Task->task_priority_id = 1;
        $boss2Task->task_status_id = 1;
        $boss2Task->save();

        $boss2Task->users()->attach($company2Boss,
            [
                "is_accepted" => rand(0,1),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);

        $this->company1 = $company1;
        $this->company2 = $company2;

        $this->boss1Task = $boss1Task;
        $this->employee1Task = $employee1Task;
        $this->boss2Task = $boss2Task;

        $this->company1Boss = $company1Boss;
        $this->company2Boss = $company2Boss;
        $this->company1Employee = $company1Employee;
    }

    /**
     * Test weather or not can user edit a task
     *
     * @return void
     */
    public function testCannotEditOtherTask()
    {
        $response = $this->put('/api/tasks/' . $this->boss2Task->id, [], [
            'Authorization' => $this->company1Boss->api_token
        ]);
        $response->assertStatus(403);
    }

    /**
     * Da li employee ne moze da menja task iz svoje firme
     */
    public function testRestrictEmployee()
    {
        $response = $this->put('/api/tasks/' . $this->boss1Task->id, [], [
           'Authorization' => $this->company1Employee->api_token
        ]);

        $response->assertStatus(403);
    }

    /**
     * Da li employee ne moze da menja task iz tudje firme
     */
    public function testCanEmployeeEditOtherCompanyTask()
    {
        $response = $this->put('/api/tasks/' . $this->boss2Task->id, [], [
            'Authorization' => $this->company1Employee->api_token
        ]);
        $response->assertStatus(403);
    }

    /**
     * Da li sme sopstveni task
     */
    public function testCanEditOwnTask()
    {
        $response = $this->put('/api/tasks/' . $this->boss1Task->id, [], [
            'Authorization' => $this->company1Boss->api_token
        ]);
        $response->assertStatus(200);
    }

    /**
     * Da li sme sopstveni task
     */
    public function testCanEditEmployeeTask()
    {
        $response = $this->put('/api/tasks/' . $this->employee1Task->id, [], [
            'Authorization' => $this->company1Boss->api_token
        ]);
        $response->assertStatus(200);
    }

    /**
     * Da li employee sme svoj
     */
    public function testCanEmployeeEditOwn()
    {
        $response = $this->put('/api/tasks/' . $this->employee1Task->id, [], [
            'Authorization' => $this->company1Employee->api_token
        ]);
        $response->assertStatus(403);
    }

    public function testCantAssignEmployeesFromOtherCompany()
    {
        $ids = factory(User::class, 5)->make()->map(function($user) {
            $user->role_id = 2;
            $user->user_status_id = 1;
            $user->company_id = $this->company2->id;
            $user->save();

            return $user->id;
        })
            ->push($this->company1Boss->id)
            ->toArray();

        $response = $this->put('/api/tasks/' . $this->employee1Task->id, [
            'employees' => $ids
        ], ['Authorization' => $this->company1Boss->api_token]);
        $response->assertStatus(403);
    }

    public function testCanAssignOwnEmployees()
    {
        $ids = factory(User::class, 5)->make()->map(function($user) {
            $user->role_id = 2;
            $user->user_status_id = 1;
            $user->company_id = $this->company1->id;
            $user->save();

            return $user->id;
        })
            ->push($this->company1Boss->id)
            ->toArray();

        $response = $this->put('/api/tasks/' . $this->employee1Task->id, [
            'employees' => $ids
        ], ['Authorization' => $this->company1Boss->api_token]);
        $response->assertStatus(200);
    }

    public function testAssignEmployees()
    {
        $ids = factory(User::class, 3)->make()->map(function($user) {
            $user->role_id = 2;
            $user->user_status_id = 1;
            $user->company_id = $this->company1->id;
            $user->save();

            return $user->id;
        })->toArray();

        $response = $this->put('/api/tasks/' . $this->boss2Task->id, [
            'employees' => $ids
        ], ['Authorization' => $this->company1Boss->api_token]);
        $response->assertStatus(403);
    }


}
