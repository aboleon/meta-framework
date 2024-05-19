<?php

namespace Aboleon\MetaFramework\Controllers;

use Illuminate\Database\Eloquent\SoftDeletes;
use Aboleon\MetaFramework\Models\Vat;
use Aboleon\MetaFramework\Traits\Responses;
use Aboleon\MetaFramework\Services\Validation\ValidationTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Throwable;

class VatController extends Controller
{
    use Responses;
    use SoftDeletes;
    use ValidationTrait;

    public function index(): Renderable
    {
        return view('aboleon-framework::vat.index')->with('data', Vat::all());
    }

    public function create(): Renderable
    {
        $data = [
            'data' => new Vat,
            'route' => route('aboleon-framework.vat.store')
        ];

        return view('aboleon-framework::vat.edit')->with($data);
    }


    public function store(): RedirectResponse
    {
        $this->validation_rules = [
            'vat.rate' => 'numeric|unique:vat,rate',
            'vat.default' => 'nullable'
        ];
        $this->validation_messages = [
            'vat.rate.numeric' => __('validation.integer', ['attribute' => __('aboleon-framework-sellable.vat.label')]),
            'vat.rate.unique' => __('validation.unique', ['attribute' => __('aboleon-framework-sellable.vat.label')]),
        ];
        $this->validation();

        try {
            $vat = Vat::create(
                $this->validated_data['vat']
            );

            $vat->manageDefaultState();

            $this->responseSuccess(__('aboleon-framework.record_created'));
            $this->redirect_route = 'aboleon-framework.vat.index';

        } catch (Throwable $e) {
            $this->responseException($e);
        } finally {
            return $this->sendResponse();
        }
    }

    public function edit(Vat $vat): Renderable
    {
        $data = [
            'data' => $vat,
            'route' => route('aboleon-framework.vat.update', $vat)
        ];

        return view('aboleon-framework::vat.edit')->with($data);
    }

    public function update(Vat $vat): RedirectResponse
    {
        $this->validation_rules = [
            'vat.rate' => 'numeric|unique:vat,rate,'.$vat->id,
            'vat.default' => 'nullable'
        ];
        $this->validation_messages = [
            'vat.rate.numeric' => __('validation.integer', ['attribute' => __('aboleon-framework-sellable.vat.label')]),
            'vat.rate.unique' => __('validation.unique', ['attribute' => __('aboleon-framework-sellable.vat.label')]),
        ];
        $this->validation();


        try {
            $vat->update(
                $this->validated_data['vat']
            );

            $vat->manageDefaultState();

            $this->responseSuccess(__('aboleon-framework.record_created'));
            $this->redirect_route = 'aboleon-framework.vat.index';

        } catch (Throwable $e) {
            $this->responseException($e);
        } finally {
            return $this->sendResponse();
        }
    }

    public function destroy(Vat $vat): RedirectResponse
    {
        try {
            if ($vat->default) {
                Vat::query()->where('id', '!=', $vat->id)->first()->update(['default' => null]);
                Cache::forget('default_vat_rate');
            }
            $vat->delete();
        } catch (Throwable $e) {
            $this->responseException($e, __('aboleon-framework-sellable.vat.is_used'));
        }

        return $this->sendResponse();

    }
}
