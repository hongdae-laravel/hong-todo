<?php

namespace App;

use Carbon\Carbon;
use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property static closed_at
 */
class Task extends Model
{
    use Taggable;

    protected $fillable = [
        'name',
        'due_date',
        'closed_at',
    ];

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

    /* D-Day 구하기 */
    public function getDdays( $now )
    {
        // return ;
        $result = "UNLIMIT";
        if ( isset($this->due_date) ) {
          $now_date = date('Y-m-d', $now);
          $due_date = substr($this->due_date, 0,10);
          if ( $now_date == $due_date ) return "D-Day";
          $_days = (strtotime($due_date.' 00:00:00')-strtotime($now_date.' 00:00:00')) / 86400 ; // 24*60*60
          $result = 'D'.( ($_days < 0)?'+':'-' ).abs($_days);
        }

        return $result;
    }

    /* 완료 표시하기 */
    public function close()
    {
        $this->closed_at = Carbon::now();
    }

    public function reopen()
    {
        $this->closed_at = null;
    }
}
