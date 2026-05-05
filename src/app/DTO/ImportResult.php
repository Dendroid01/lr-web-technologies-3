<?php

namespace App\DTO;

class ImportResult
{
    public function __construct(
        public readonly int $imported,
        public readonly int $skipped,
        public readonly int $updated = 0,
    ) {}

    public function toArray(): array
    {
        return [
            'imported' => $this->imported,
            'skipped'  => $this->skipped,
            'updated'  => $this->updated,
        ];
    }
}
