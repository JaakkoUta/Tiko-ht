<?php
/**
 * Created by PhpStorm.
 * User: ritol
 * Date: 11.4.2017
 * Time: 23.37
 */

namespace App\App\Controllers;

use App\Core\App;
use App\App\Models\Teacher;
use App\App\Models\User;
use App\App\Models\TaskList;
use App\App\Models\Gate;

class TeacherController
{
    public function __construct(){
        if(Gate::hasRole('opiskelija'))
            header('Location:/student-home');
    }
    public function index()
    {
        $tasklists = TaskList::findAllWhere("ID_KAYTTAJA", $_SESSION['id_kayttaja']);

        return view('teacher-home', compact('tasklists'));
    }
    public function create()
    {
        return view('login');
    }

    public function save()
    {
        $req = App::get('request');
        $teacher = Teacher::findWhere('ONRO', $req->get('onro'));

        if ($teacher && password_verify($req->get('salasana'), $teacher->SALASANA)) {
            $user = User::find($teacher->ID_KAYTTAJA);

            $_SESSION['id_kayttaja'] = $teacher->ID_KAYTTAJA;
            $_SESSION['nimi'] = $teacher->NIMI;
            $_SESSION['onro'] = $teacher->ONRO;
            $_SESSION['rooli'] = $user->ROOLI;

            header('Location: /teacher-home');
        }

        header('Location: / ');
    }
}