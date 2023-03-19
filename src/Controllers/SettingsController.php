<?php

namespace MetaFramework\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Artisan;
use MetaFramework\Accessors\Routing;
use MetaFramework\Models\Setting;
use MetaFramework\Traits\Responses;

class SettingsController extends Controller
{
    use Responses;



    public function index(): Renderable
    {
        return view(Routing::backend().'.show.settings')->with([
            'config_settings' => config('settings'),
            'settings' => Setting::getAllSettings(),
        ]);
    }

    public function update()
    {

        try {
            $configs = Setting::getConfigElements();
            $rules = Setting::getValidationRules();


            $data = array_intersect_key(request()->input(), array_flip($configs));


            foreach ($data as $key => $val) {

                if ($rules && array_key_exists($key, $rules)) {
                    $this->validate(request(), $rules);
                }
                Setting::add($key, $val);

            }

            Artisan::call('cache:clear');

            $this->responseSuccess('Configuration enregistré avec succès');
        } catch (\Throwable $e) {
            $this->responseException($e);
        }

        return $this->sendResponse();
    }
}
