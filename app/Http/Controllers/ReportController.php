<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Document;

public function exportPdf()
{
    $documents = Document::with('student', 'type')->get();
    $pdf = Pdf::loadView('reports.documents', compact('documents'));
    return $pdf->download('laporan-dokumen-' . now()->format('Ymd') . '.pdf');
}
