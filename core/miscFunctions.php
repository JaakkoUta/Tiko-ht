<?php

use App\App\Models\Session;
use App\App\Models\TaskCompletion;
use App\App\Models\Attempt;
use App\App\Models\Query;
use App\Core\App;

function anyTasksLeft($taskIndex, $tasks, $session)
{
    if ($taskIndex >= count($tasks)) {
        Session::update($session->ID_SESSIO, [
            'LOPAIKA' => date("Y-m-d H:i:s")
        ]);

        return false;
    }
    return true;
}

function setSessionTimeOfBeginning($taskIndex, $session)
{
    if ($taskIndex == 0) {
        Session::update($session->ID_SESSIO, [
            'ALKAIKA' => date("Y-m-d H:i:s")
        ]);
    }
}

function createTaskCompletion($sessionId, $tasks, $taskIndex, $timeAtStart)
{
    $taskCompletion = TaskCompletion::findTaskCompletion(
        'ID_SESSIO', $sessionId,
        'ID_TEHTAVA', $tasks[$taskIndex]->ID_TEHTAVA
    );

    if (! $taskCompletion) {
        TaskCompletion::create([
            'ID_TEHTAVA' => $tasks[$taskIndex]->ID_TEHTAVA,
            'ID_SESSIO' => $sessionId,
            'ALKAIKA' => $timeAtStart
        ]);
    }
}

function answersLowerCase($answers)
{
    $lowerCaseAnswersArray = [];

    foreach ($answers as $answer) {
        $lowerCaseAnswersArray[] = strtolower($answer->VASTAUS);
    }

    return $lowerCaseAnswersArray;
}

function correctAnswer($answer, $answerArray)
{
    return in_array($answer, $answerArray);
}

function createAttempt($req, $answer, $correct)
{
    $attempts = Attempt::findAllAttempts(
        'ID_TEHTAVA',
        $req->get('tehtavaId'),
        'ID_SESSIO',
        $req->get('sessionId')
    );

    Attempt::create([
        'ID_TEHTAVA' => $req->get('tehtavaId'),
        'ID_SESSIO' => $req->get('sessionId'),
        'YRITYSKERTA' => count($attempts)+1,
        'VASTAUS' => $answer,
        'ALKAIKA' => $req->get('timeAtStart'),
        'LOPAIKA' => date("Y-m-d H:i:s"),
        'OLIKOOIKEIN' => $correct
    ]);

    return count($attempts);
}

function updateTaskCompletion($req) {
    TaskCompletion::updateTaskCompletion(
        $req->get('tehtavaId'),
        $req->get('sessionId'),
        date("Y-m-d H:i:s")
    );
}
function arrayToHtml($tableName){
    $table = Query::rawQuery(Session::selectFrom($tableName, '*'));
    $columnNames = Query::rawQuery(Session::selectColumnNames($tableName));
    $tableHtml = "<table style=\"width:100%\"><caption>$tableName</caption><tr>";
    foreach($columnNames as $row) {
        foreach ($row as $index)
            $tableHtml .= "<th>" . $index . "</th>";
    }
    $tableHtml .= "</tr>";
    foreach($table as $row){
        $tableHtml .= "<tr>";
        foreach($row as $index)
            $tableHtml .= "<td>".$index."</td>";
        $tableHtml .= "</tr>";
    }
    $tableHtml .= "</table><br>";
    return $tableHtml;
}