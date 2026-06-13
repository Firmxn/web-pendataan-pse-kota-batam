<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    /**
     * Download dokumen dengan pengecekan otorisasi via policy
     */
    public function download(Document $document): StreamedResponse
    {
        // Pastikan entitas pemilik dokumen masih ada (polymorphic parent)
        if (!$document->documentable) {
            abort(404, __('messages.error.not_found'));
        }

        // Otorisasi: pastikan user berhak melihat entitas terkait
        $this->authorize('view', $document->documentable);

        // Verifikasi file masih tersedia di private storage
        if (!Storage::disk('private')->exists($document->file_path)) {
            abort(404, 'File not found');
        }

        // Stream file untuk preview (inline, bukan download langsung)
        return Storage::disk('private')->response(
            $document->file_path,
            $document->original_name,
            ['Content-Disposition' => 'inline; filename="' . $document->original_name . '"']
        );
    }
}
