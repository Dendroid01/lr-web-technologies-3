<?php

namespace App\Services;

use App\Models\BlogPost;
use Carbon\Carbon;
use App\Http\Requests\BlogPostRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BlogImportService
{
    public function import($file): array
    {
        $imported = 0;
        $skipped = 0;

        DB::beginTransaction();

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

                [$title, $message, $author, $created_at] = $row;

                $validator = Validator::make([
                    'title' => $title,
                    'message' => $message,
                    'author' => $author,
                ], (new BlogPostRequest())->rules());

                if ($validator->fails()) {
                    $skipped++;
                    continue;
                }

                try {
                    $createdAt = Carbon::parse($created_at);
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
                    'title' => $title,
                    'message' => $message,
                    'author' => $author,
                    'created_at' => $createdAt,
                    'image' => null,
                ]);

                $imported++;
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        } finally {
            fclose($handle);
        }
        return [
            'imported' => $imported,
            'skipped' => $skipped,
        ];
    }
}
