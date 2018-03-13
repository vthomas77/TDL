<?php

namespace App\Http\Controllers;

use App\Task;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskController extends Controller {

    public function createTask($token, $taskName, $rank, $idCard) {
        $newTask = Task::createTask($token, $taskName, $rank, $idCard);

        return response()->json($newTask);
    }

    public function dropTask($token, $idTask) {
        $dropedTask = Task::dropTask($token, $idTask);

        return response()->json($dropedTask);
    }

    public function readTask($token, $idCard) {
        $allTasks = Task::readTask($token, $idCard);

        return response()->json($allTasks);
    }

    public function UpdateTaskCompletion($taskID,$taskStatus) {
      return response()->json(Task::UpdateTaskCompletion($taskID,$taskStatus));
    }
}
