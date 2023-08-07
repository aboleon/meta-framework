<?php


use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class Attestation
{

    use \MetaFramework\Traits\DomPdf;
    public function __construct(
        public ModelExample     $modelExample,
    )
    {
        $this->pdf = Pdf::loadView('pdf.attestation_example', ['data' => $modelExample]);
    }

    public function __invoke(): Response
    {
        return $this->stream();
    }

    public function stream(): Response
    {
        return $this->pdf->stream();
    }

    public function output(): string
    {
        return $this->pdf->output();
    }
}
