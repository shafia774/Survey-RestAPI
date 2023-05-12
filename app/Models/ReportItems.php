<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportItems extends Model
{
    use HasFactory;

    public function report()
    {
        return $this->belongsTo(Reports::class,  'report_id');
    }

    public function question()
    {
        return $this->belongsTo(Questions::class,  'question_id');
    }
}
