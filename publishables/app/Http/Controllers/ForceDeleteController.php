<?php

namespace App\Http\Controllers;


use App\Rules\IsObject;
use MetaFramework\Services\Validation\ValidationTrait;
use Throwable;

class ForceDeleteController extends Controller
{
    use ValidationTrait;

    public function process()
    {
        $this->basicValidation();

        try {

            $object = request('object');
            $model = new $object;

            if(method_exists($model, 'trashed')) {
                $model = $model->withTrashed();
            }
            $model = $model->find(request('id'));

            if(method_exists($model, 'forceDeleteBefore')) {
                $model->forceDeleteBefore();
            }
            $model->forceDelete();

            $this->responseSuccess(__('ui.record_deleted'));

        } catch (Throwable $e) {

            $this->responseException($e);

        } finally {

            return $this->sendResponse();
        }

    }

    private function basicValidation()
    {
        $this->validation_rules = [
            'object' => ['required', new IsObject],
            'id' => ['required', 'numeric']
        ];

        $this->validation_messages = [
            'object.required' => __('validation.required', ['attribute' => 'Objet de la requête de suppresion']),
            'id.required' => __('validation.required', ['attribute' => "L'id à supprimer"]),
            'id.numeric' => __('validation.required', ['attribute' => "L'id à supprimer n'est pas numérique"]),
        ];
        $this->validation();
    }
}
