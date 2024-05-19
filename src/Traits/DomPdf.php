<?php

namespace Aboleon\MetaFramework\Traits;

use Barryvdh\DomPDF\Pdf;
use Illuminate\Http\Response;

trait DomPdf
{

    private Pdf $pdf;
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


    public function binary(): string
    {
        return $this->output();
    }
    public function download(string $filename='pdf_document.pdf'): Response
    {
        return $this->pdf->download($filename);
    }
}
