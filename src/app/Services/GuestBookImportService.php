<?php

namespace App\Services;

use App\Models\GuestBookMessage;
use Carbon\Carbon;
use App\Http\Requests\GuestBookRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class GuestBookImportService
{
    public function import($file): array
    {
        $imported = 0;
        $skipped = 0;
        $updated = 0;

        DB::beginTransaction();

        try {
            if (($handle = fopen($file->getPathname(), 'r')) !== false) {

                while (($row = fgetcsv($handle, 0, ';')) !== false) {
                    $row = array_map('trim', $row);

                    if (count($row) < 6) {
                        $skipped++;
                        continue;
                    }

                    [$created_at, $last_name, $first_name, $middle_name, $email, $message] = $row;

                    try {
                        $createdAt = Carbon::createFromFormat('d.m.y', $created_at)->startOfDay();
                    } catch (\Exception $e) {
                        $skipped++;
                        continue;
                    }

                    $validator = Validator::make([
                        'last_name'   => $last_name,
                        'first_name'  => $first_name,
                        'middle_name' => $middle_name,
                        'email'       => $email,
                        'message'     => $message,
                    ], (new GuestBookRequest())->rules(), (new GuestBookRequest())->messages());

                    if ($validator->fails()) {
                        $skipped++;
                        continue;
                    }

                    $messageHash = hash('sha256', $message);
                    $existing = GuestBookMessage::where('message_hash', $messageHash)->first();

                    if ($existing) {
                        $existing->update([
                            'last_name'   => $last_name,
                            'first_name'  => $first_name,
                            'middle_name' => $middle_name,
                            'email'       => $email,
                            'created_at'  => $createdAt,
                        ]);
                        $updated++;
                    } else {
                        GuestBookMessage::create([
                            'created_at'  => $createdAt,
                            'last_name'   => $last_name,
                            'first_name'  => $first_name,
                            'middle_name' => $middle_name,
                            'email'       => $email,
                            'message'     => $message,
                        ]);
                        $imported++;
                    }
                }

                fclose($handle);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return [
            'imported' => $imported,
            'skipped'  => $skipped,
            'updated'  => $updated,
        ];
    }
}
