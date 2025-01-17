<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cv_lang extends Model
{
    use HasFactory;

    protected $table = 'cv_langs';
    public $timestamps = false;
    protected $fillable = [
        'cv_id',
        'l_id',
    ];

    public function cv(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(cv::class, 'cv_id');
    }

    public function language(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(languages::class, 'l_id');
    }
}
