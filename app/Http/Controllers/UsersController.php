<?php

namespace App\Http\Controllers;

class UsersController extends Controller
{
    /**
     * undocumented function.
     *
     * @author
     **/
    public function create()
    {
        $data = [
            'forms' => true,
            'pagetitle' => 'Add New User',
            'titles' => [(object)
                [
                'title' => 'New User Details',
                'icon' => 'fa fa-user',
                ],
            ],
            'wizard' => (object) [
                'form' => (object) [
                    'action' => route('users.save'),
                    'method' => 'post',
                ],
            ],
        ];

        return view('users.create-user', $data);
    }
}
