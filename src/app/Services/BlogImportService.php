<?php

namespace App\Services;

use App\Models\BlogPost;
use App\DTO\ImportResult;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\BlogPostRequest;

class BlogImportService
{
    public function import(UploadedFile $file): ImportResult
    {
        $imported = 0;
        $skipped = 0;

        DB::transaction(function () use ($file, &$imported, &$skipped) {
            $handle = fopen($file->getPathname(), 'r');
            if (!$handle) {
                throw new \RuntimeException('Could not open the file');
            }

            try {
                fgetcsv($handle, 0, ';');

                while (($row = fgetcsv($handle, 0, ';')) !== false) {
                    $row = array_map('trim', $row);

                    if (count($row) < 4) {
                        $skipped++;
                        continue;
                    }

                    [$title, $message, $author, $createdAtRaw] = $row;

                    $validator = Validator::make(
                        compact('title', 'message', 'author'),
                        (new BlogPostRequest())->rules()
                    );

                    if ($validator->fails()) {
                        $skipped++;
                        continue;
                    }

                    try {
                        $createdAt = Carbon::parse($createdAtRaw);
                    } catch (\Exception $e) {
                        $skipped++;
                        continue;
                    }

                    $exists = BlogPost::where('title', $title)
                        ->where('author', $author)
                        ->where('created_at', $createdAt)
                        ->exists();

                    if ($exists) {
                        $skipped++;
                        continue;
                    }

                    BlogPost::create([
                        'title'      => $title,
                        'message'    => $message,
                        'author'     => $author,
                        'created_at' => $createdAt,
                        'image'      => null,
                    ]);

                    $imported++;
                }
            } finally {
                fclose($handle);
            }
        });

        return new ImportResult($imported, $skipped);
    }
}
