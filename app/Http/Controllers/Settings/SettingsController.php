<?php

namespace App\Http\Controllers\Settings;

use Bouncer;
use App\Entities\Role;
use App\Support\Config;
use App\Entities\Ability;
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
     * Show the Access Control List settings tab.
     *
     * @return Illuminate\Http\Response
     **/
    public function aclSettings($role = null)
    {
        $data = [
            'abilities' => Ability::all(),
            'roles' => Role::all(),
            'group' => $role ? Role::where('name', $role)->first() : Role::first(),
        ];
        if (null == $data['group']) {
            abort(404);
        }

        return view('settings.acl-settings', $data);
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function updateAclSettings(Role $role, Request $request)
    {
        if ($request->has('abilities')) {
            Ability::all()->each(function ($ability) use ($role) {
                Bouncer::disallow($role)->to($ability->name);
            });
            $abilities = $request->get('abilities');
            foreach ($abilities as $ability) {
                Bouncer::allow($role)->to($ability);
            }

            return with_info(trans('messages.acl_updated'));
        }
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
        cache()->forget('app_config');
        if ($request->wantsJson()) {
            return response(['status' => 'Success', 'message' => trans('messages.config_add_ok')]);
        }

        return with_info();
    }
}
