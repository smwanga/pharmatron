<?php

namespace App\Http\Controllers\Settings;

use App\Support\Config;
use App\Entities\AppConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    /**
     * AppConfig eloquent model.
     *
     * @var AppConfig
     **/
    protected $config;

    /**
     * Repository.
     *
     * @var Config
     **/
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @param AppConfig $config
     **/
    public function __construct(AppConfig $config)
    {
        $this->config = $config;
        $this->repository = new Config($config->all());
    }

    /**
     * Show the general settings tab.
     *
     * @return Illuminate\Http\Response
     **/
    public function index()
    {
        $config = $this->repository;

        return view('settings.general-settings', compact('config'));
    }

    /**
     * Show the email settings tab.
     *
     * @return Illuminate\Http\Response
     **/
    public function emailSettings()
    {
        $config = $this->repository;

        return view('settings.email-settings', compact('config'));
    }

    /**
     * Show view for creating a new config setting.
     *
     * @return Illuminate\Http\Response
     **/
    public function createConfigItem()
    {
        return view('settings.modals.create-config');
    }

    /**
     * Save the config settings.
     *
     * @param Request $request
     **/
    public function saveConfigSettings(Request $request)
    {
        $this->validate($request, []);
    }

    /**
     * undocumented function.
     *
     * @return Illuminate\Http\Response
     **/
    public function saveConfigItem(Request $request)
    {
        $this->validate($request, ['key' => 'required|alpha_dash|max:64|string|unique:app_configs', 'value' => 'required|string|max:1000']);
        $this->config->create($request->input());
        if ($request->wantsJson()) {
            return response(['status' => 'Success', 'message' => trans('messages.config_add_ok')]);
        }

        return with_info();
    }
}
