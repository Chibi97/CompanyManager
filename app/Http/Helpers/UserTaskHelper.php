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

    private static function getUser()
    {
        if(session()->has('user')) {
            $user = session()->get('user')->refresh();
        } else {
            $user = CompanyManager::getInstance()->retrieve('user');
        }
        return $user;
    }

    public function getPendingTasks()
    {
        $user = self::getUser();
        return $user->getTasksFilteredByAcceptance();
    }

    public function getUserTasks()
    {
        $user = self::getUser();
        return $user->tasks->load('users','taskPriority','taskStatus');
    }

    public function getAvailableTasks()
    {
        $user = self::getUser();
        return $user->getAvailableTasks();
    }

}