<?php

namespace App;

use Carbon\Carbon;
use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use Taggable;

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

    public function getTagNamesToCsv(Task $task)
    {
        if (empty($task->tagNames())) {
            $result = "";
        } else {
            $result = implode(",", $task->tagNames());
        }

        return $result;
    }
}
