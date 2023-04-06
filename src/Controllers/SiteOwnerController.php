<?php

namespace MetaFramework\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\{
    RedirectResponse,
    Request};
use MetaFramework\Models\SiteOwner;
use MetaFramework\Services\Validation\ValidationTrait;
use MetaFramework\Traits\Responses;
use Throwable;

class SiteOwnerController extends Controller
{
    use Responses;
    use ValidationTrait;

    public function index(): Renderable
    {
        return view('mfw::siteowner')->with('data', SiteOwner::first());
    }

    public function store(Request $request): RedirectResponse
    {
        $this->request_validation();
        $this->validation();
        try {
            $object = SiteOwner::firstOrNew();
            $object->name = $request['name'];
            $object->address = $request['address'];
            $object->manager = $request['manager'];
            $object->phone = $request['phone'];
            $object->vat = $request['vat'];
            $object->siret = $request['siret'];
            $object->email = $request['email'];
            $object->zip = $request['zip'];
            $object->ville = $request['ville'];
            $object->save();

            $this->responseSuccess("Les informations ont été enregistrées.");

        } catch (Throwable $e) {
            $this->responseException($e);
        } finally {
            return $this->sendResponse();
        }
    }


    private function request_validation(): void
    {
        $this->validation_rules = [
            'name' => 'required',
            'address' => 'required',
            'manager' => 'required',
            'phone' => 'required',
            'vat' => 'required',
            'siret' => 'required',
            'email' => 'required',
            'zip' => 'required',
            'ville' => 'required',
        ];

        $this->validation_messages = [
            'name.required' => "Le nom de la structure n'est pas renseigné.",
            'address.required' => "L'adresse de la structure n'est pas renseignée.",
            'manager.required' => "Le gérant de la structure n'est pas renseigné.",
            'phone.required' => "Le numéro de téléphone n'est pas renseigné.",
            'vat.required' => "Le numéro TVA n'est pas renseigné.",
            'siret.required' => "Le SIRET n'est pas renseigné.",
            'email.required' => "L'adresse e-mail n'est pas renseignée.",
            'zip.required' => "Le code postal n'est pas renseigné.",
            'ville.required' => "La ville n'est pas renseignée.",
        ];
    }
}
