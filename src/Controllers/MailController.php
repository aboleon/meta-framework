<?php

namespace Aboleon\MetaFramework\Controllers;

use Aboleon\MetaFramework\Interfaces\Mailer;
use Illuminate\Http\RedirectResponse;
use Aboleon\MetaFramework\Traits\Ajax;
use Aboleon\MetaFramework\Traits\Responses;
use Throwable;

class MailController extends Controller
{
    use Ajax;
    use Responses;

    public function distribute(string $type, string $identifier): self
    {

        $mailer = '\App\Mailer\\' . ucfirst($type);

        if (class_exists($mailer) && in_array(Mailer::class, class_implements($mailer))) {

            try {
                (new $mailer($identifier))->send();
                $this->responseSuccess("L'email a été envoyé.");
            } catch (Throwable $e) {
                $this->responseException($e);
            }

        } else {
            $this->responseError('Mailer inconnu');
        }

        return $this;

    }

    public function render(string $type, string $identifier): RedirectResponse
    {
        $this->distribute($type, $identifier);

        return $this->sendResponse();
    }
}
