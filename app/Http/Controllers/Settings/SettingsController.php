<?php

namespace App\Http\Controllers\Settings;

use App\Entities\AppConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param AppConfig $config
     **/
    public function __construct(AppConfig $config)
    {
        $this->config = $config;
    }

    /**
     * undocumented function.
     *
     * @return Illuminate\Http\Response
     **/
    public function createConfigItem()
    {
        return view('settings.modals.create-config');
    }

    /**
     * undocumented function.
     *
     * @return Illuminate\Http\Response
     **/
    public function saveConfigItem(Request $request, AppConfig $config)
    {
        $this->validate($request, ['key' => 'required|alpha_dash|max:64|string|unique:app_configs', 'value' => 'required|string|max:1000']);
        $config->create($request->input());
        if ($request->wantsJson()) {
            return response(['status' => 'Success', 'message' => trans('messages.config_add_ok')]);
        }

        return with_info();
    }
}
