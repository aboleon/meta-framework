<?php

namespace App\Http\Controllers;

use Aboleon\MetaFramework\Controllers\Controller;
use Aboleon\MetaFramework\Services\Validation\ValidationTrait;
use Aboleon\MetaFramework\Traits\Responses;
use App\Models\AppOwner;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Facades\Cache;
use Throwable;

class AppOwnerController extends Controller
{
    use Responses;
    use ValidationTrait;

    public function index(): Renderable
    {
        return view('appowner')->with('data', AppOwner::first());
    }

    public function store(Request $request): RedirectResponse
    {
        $this->request_validation();
        $this->validation();

        try {
            $object = AppOwner::firstOrNew();
            $object->name = $request['name'];
            $object->address = $request['address'];
            $object->manager = $request['manager'];
            $object->phone = $request['phone'];
            $object->vat_number = $request['vat_number'];
            $object->reg_number = $request['reg_number'];
            $object->email = $request['email'];
            $object->zip = $request['zip'];
            $object->locality = $request['locality'];
            $object->save();

            $this->responseSuccess(__('aboleon-framework.record_created'));

            Cache::forget('aboleon-framework_siteowner');

        } catch (Throwable $e) {
            $this->responseException($e);
        }
        return $this->sendResponse();
    }

    private function request_validation(): void
    {
        $this->validation_rules = [
            'name' => 'required',
            'address' => 'required',
            'manager' => 'required',
            'phone' => 'required',
            'vat_number' => 'required',
            'reg_number' => 'required',
            'email' => 'required',
            'zip' => 'required',
            'locality' => 'required',
        ];

        $this->validation_messages = [
            'name.required' => __('appowner.name'),
            'address.required' => __('address.name'),
            'manager.required' => __('manager.name'),
            'phone.required' => __('phone.name'),
            'vat_number.required' => __('vat_number.name'),
            'reg_number.required' => __('reg_number.name'),
            'email.required' => __('email.name'),
            'zip.required' => __('zip.name'),
            'locality.required' => __('locality.name'),
        ];
    }
}
