<?php

namespace MetaFramework\Traits;

use Illuminate\Http\Response;

trait DomPdf
{

    private \Barryvdh\DomPDF\Pdf $pdf;
    // composer require "barryvdh/laravel-dompdf"

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