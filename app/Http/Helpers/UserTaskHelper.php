<?php
/**
 * Created by PhpStorm.
 * User: oljaw
 * Date: 3/28/2019
 * Time: 11:36 PM
 */

namespace App\Http\Helpers;


class UserTaskHelper
{
    private function getUser()
    {
        if(session()->has('user')) {
            $user = session()->get('user');
        } else {
            $user = CompanyManager::getInstance()->retrieve('user');
        }

        return $user;
    }

    public function getPendingTasks()
    {
        $user = $this->getUser();
        return $user->getTasksFilteredByAcceptance();
    }

    public function getUserTasks()
    {
        $user = $this->getUser();
        return $user->tasks;
    }

    public function getAvailableTasks()
    {
        $user = $this->getUser();
        return $user->getAvailableTasks();
    }

}