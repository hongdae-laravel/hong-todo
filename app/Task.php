<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedDate(Task $task)
    {
        $formattedDate = Carbon::createFromFormat("Y-m-d H:i:s", $task->created_at);
        $format = "Y-m-d H:i";
        return $formattedDate->format($format);
    }
}
