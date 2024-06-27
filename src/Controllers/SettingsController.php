<?php

namespace Aboleon\MetaFramework\Controllers;

use Aboleon\MetaFramework\Models\Setting;
use Aboleon\MetaFramework\Services\Validation\ValidationTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    use ValidationTrait;

    public function index(): Renderable
    {
        return view('aboleon-framework::settings')->with([
            'config_settings' => config('aboleon-framework-settings'),
            'settings' => Setting::getAllSettings(),
        ]);
    }

    public function store(): RedirectResponse
    {
        $this->validation_rules = Setting::getValidationRules();
        $this->validation_messages = trans('aboleon-framework-settings.validation');

        $this->validation();

        DB::beginTransaction();
        try {

            foreach ($this->validatedData() as $key => $value) {
                Setting::updateOrCreate(['name' => $key], ['value' => $value]);
            }
            DB::commit();
            cache()->forget('aboleon-framework-settings');

            $this->responseSuccess('Configuration enregistré avec succès');
        } catch (\Throwable $e) {
            $this->responseException($e);
            DB::rollBack();
        }

        return $this->sendResponse();
    }
}
