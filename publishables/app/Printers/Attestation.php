<?php


use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class Attestation
{

    use \MetaFramework\Traits\DomPdf;

    public function __construct(
        public ModelExample $modelExample,
    )
    {
        $this->pdf = Pdf::loadView('pdf.attestation_example', ['data' => $modelExample]);
    }
}
