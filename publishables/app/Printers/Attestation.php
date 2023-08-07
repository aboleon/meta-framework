<?php


use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class Attestation
{

    use \MetaFramework\Traits\DomPdf;

    public function __construct(
        public ModelExample $modelExample,
    )
    {
        $this->pdf = PDF::loadView('pdf.attestation_example', ['data' => $modelExample]);
    }
}
