<?php

// app/Models/TestResult.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $fillable = [
        'fullname',
        'group_name',
        'answers',
        'results',
        'total',
        'correct',
    ];

    protected $casts = [
        'answers' => 'array',
        'results' => 'array',
    ];

    public function successRate(): float
    {
        if ($this->total === 0) {
            return 0;
        }

        return round(($this->correct / $this->total) * 100, 2);
    }
}
