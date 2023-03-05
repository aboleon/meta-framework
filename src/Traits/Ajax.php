<?php

declare(strict_types=1);

namespace MetaFramework\Traits;

use MetaFramework\Traits\Responses;
use Illuminate\Http\JsonResponse;

trait Ajax
{
    use Responses;

    public function distribute(): array|JsonResponse
    {
        $this->response['input'] = request()->all();
        if (request()->filled('callback')) {
            $this->response['callback'] = request('callback');
        }

        if (!request()->filled('action')) {
            $this->responseError('Cette requête ne peut pas être interprêtée.');
            return response()->json($this->response, 400);
        }

        if (!method_exists(self::class, request('action'))) {
            $this->responseError('Cette requête ne peut pas être traitée.');
            return response()->json($this->response, 405);
        }

        return $this->{request('action')}();
    }
}
