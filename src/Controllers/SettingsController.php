<?php

namespace Aboleon\MetaFramework\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Aboleon\MetaFramework\Accessors\Routing;
use Aboleon\MetaFramework\Models\Setting;
use Aboleon\MetaFramework\Traits\Responses;

class SettingsController extends Controller
{
    use Responses;

    public function index(): Renderable
    {
        return view('aboleon-framework::settings')->with([
            'config_settings' => config('aboleon-framework-settings'),
            'settings' => Setting::getAllSettings(),
        ]);
    }

    public function update(): RedirectResponse
    {

        try {
            $configs = Setting::getConfigElementsKeys();
            $rules = Setting::getValidationRules();


            $data = array_intersect_key(request()->input(), array_flip($configs));


            foreach ($data as $key => $val) {

                if ($rules && array_key_exists($key, $rules)) {
                    $this->validate(request(), $rules);
                }
                Setting::add($key, $val);

            }

            cache()->forget('aboleon-framework-settings');

            $this->responseSuccess('Configuration enregistré avec succès');
        } catch (\Throwable $e) {
            $this->responseException($e);
        }

        return $this->sendResponse();
    }
}
