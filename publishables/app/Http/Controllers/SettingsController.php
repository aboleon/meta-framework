<?php

namespace App\Http\Controllers;

use Aboleon\MetaFramework\Controllers\Controller;
use Aboleon\MetaFramework\Services\Validation\ValidationTrait;
use App\Models\Setting;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    use ValidationTrait;

    public function index(): Renderable
    {
        return view('settings')->with([
            'config_settings' => config('aboleon-framework-settings'),
            'settings' => Setting::getAllSettings(),
        ]);
    }

    public function update(): RedirectResponse
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
