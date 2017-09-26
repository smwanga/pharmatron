<?php

namespace App\Http\Controllers\Settings;

use App\Entities\Ability;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbilityController extends Controller
{
    /**
     * Ability model.
     *
     * @var Ability
     */
    protected $ability;

    /**
     * Create a controller instance.
     *
     * @param Ability $ability
     */
    public function __construct(Ability $ability)
    {
        $this->ability = $ability;
    }

    /**
     * Show the form for creating a new ability.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.modals.new-ability');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|alpha_dash|unique:abilities',
            'title' => 'required|string|max:255',
        ];
        $this->validate($request, $rules);
        $ability = $this->ability->create($request->only(array_keys($rules)));

        return ['status' => 'succes', 'Ability created successully', 'ability' => $ability];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Ability $ability)
    {
        return view('settings.modals.edit-ability', compact('ability'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ability $ability)
    {
        $this->validate($request, ['title' => 'required|string']);
        $ability->update($request->only('title'));

        return ['status' => 'success', 'message' => 'Ability was updated'];
    }
}
