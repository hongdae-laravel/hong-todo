<?php

namespace Tests\Unit;

use App\Task;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TaskTest extends TestCase
{
//    use DatabaseMigrations;

    /** @test */
    function a_task_has_name()
    {
        $task = factory(Task::class)->create();
        $this->assertNotNull($task->name);

        // teardown
        $task->delete();
    }

    /** @test */
    function a_task_can_has_due_date()
    {
        $task = factory(Task::class)->create([
            'due_date' => Carbon::parse('1 week'),
        ]);
        $this->assertNotNull($task->due_date);

        // teardown
        $task->delete();
    }

    /** @test */
    function a_task_can_be_closed()
    {
        $task = factory(Task::class)->create();

        // DB에 closed_at 컬럼이 있는지 확인하기 위해 체크
        $this->assertDatabaseHas('tasks', ['closed_at' => null]);

        $task->update([
            'closed_at' => Carbon::now(),
        ]);
        $this->assertNotNull($task->fresh()->closed_at);

        // teardown
        $task->delete();
    }

    /** @test */
    function a_task_can_be_reopen()
    {
        $task = factory(Task::class)->create(['closed_at' => Carbon::now()]);

        $task->update([
            'closed_at' => null,
        ]);
        $this->assertNull($task->fresh()->closed_at);

        // teardown
        $task->delete();
    }
}
