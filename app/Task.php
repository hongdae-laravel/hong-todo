<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
      'name',
      'due_date' // 완료일
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

    /* D-Day 구하기 */
    public function getDdays( $now )
    {
        date_default_timezone_set('Asia/Seoul'); // 한국시간 문제
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
}
