@extends('layouts.app')

@section('append_css')
  <link href="{{ elixir('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
  <div class="container">
    <div class="col-sm-offset-2 col-sm-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          New Task
        </div>

        <div class="panel-body">
          <!-- Display Validation Errors -->
          @include('common.errors')

          @if($task)
            <form action="" method="POST" class="form-horizontal">
            {{ csrf_field() }}
            {{ method_field('put') }}

            <!-- Task Name -->
              <div class="form-group">
                <label for="task-name" class="col-sm-3 control-label">Task</label>

                <div class="col-sm-6">
                  <input type="text" name="name" id="task-name" class="form-control" value="{{ $task->name }}">
                </div>
              </div>

            <!-- 달력 컴포넌트 -->
              <div class="form-group">
                <label for="due-date" class="col-sm-3 control-label">Due Date</label>
                <div class="col-sm-6">
                  <div class='input-group date' id='due-date'>
                      <input type='text' class="form-control" name="due_date" value="{{ $task->due_date }}" placeholder="만료일">
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
                </div>
              </div>

              <!-- Add Task Button -->
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                  <button type="submit" class="btn btn-default">
                    <i class="fa fa-btn fa-plus"></i>Edit Tasks
                  </button>
                </div>
              </div>
            </form>
          @else
          <!-- New Task Form -->
            <form action="{{ route('tasks.store') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- Task Name -->
              <div class="form-group">
                <label for="task-name" class="col-sm-3 control-label">Task</label>
                <div class="col-sm-6">
                  <input type="text" name="name" id="task-name" class="form-control" value="{{ old('task') }}">
                </div>
              </div>
            <!-- 달력 컴포넌트 -->
              <div class="form-group">
                <label for="due-date" class="col-sm-3 control-label">Due Date</label>

                <div class="col-sm-6">
                  <div class='input-group date' id='due-date'>
                      <input type='text' class="form-control" name="due_date" />
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
                </div>
              </div>

              <!-- Add Task Button -->
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                  <button type="submit" class="btn btn-default">
                    <i class="fa fa-btn fa-plus"></i>Add Tasks
                  </button>
                </div>
              </div>
            </form>
          @endif
        </div>
      </div>

      <!-- Current Tasks -->
      @if (count($tasks) > 0)
        <div class="panel panel-default">
          <div class="panel-heading">
            Current Tasks
          </div>

          <div class="panel-body">
            <table class="table table-striped task-table">
              <thead>
              <th>Task</th>
              <th>&nbsp;</th>
              </thead>
              <tbody>
              @foreach ($tasks as $task)

                <tr data-id="{{ $task->id }}">
                  <td class="table-text">
                    <div><span>{{ $task->getFormattedDate($task) }}</span>
                    <span class="label label-default" data-toggle="tooltip" data-placement="top" title="{{ $task->due_date }}">{{ $task->getDdays($now) }}</span>
                    @if( $task->closed_at )
                      <s>{{ $task->name }}</s>
                    @else
                      <span>{{ $task->name }}</span>
                    @endif
                    </div>
                    <input type="text" class="tags" name="tags" value="{{ $task->getTagNamesToCsv($task) }}" data-role="tagsinput" placeholder="Tag (comma separated)">
                  </td>
                  <!-- Task Done Button -->
                  <td>
                    <form action="{{ url('tasks/' . $task->id) }}" method="POST">
                      {{ csrf_field() }}
                      {{ method_field('put') }}
                      <input type="hidden" name="name" id="task-name" class="form-control" value="{{ $task->name }}">
                      <input type='hidden' class="form-control" name="due_date" value="{{ $task->due_date }}" placeholder="만료일">
                      @if( $task->closed_at )
                        <button type="submit"  class="btn btn-danger">
                          <i class="fa fa-btn fa-circle-o"></i> 열기
                        </button>
                      @else
                        <input type='hidden' class="form-control" name="closed_at" value="1">
                        <button type="submit"  class="btn btn-primary">
                          <i class="fa fa-btn fa-close"></i> 닫기
                        </button>
                      @endif
                    </form>
                  </td>
                  <!-- Task Delete Button -->
                  <td>
                    <form action="{{ url('tasks/' . $task->id) }}" method="POST">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <a href="{{ url('tasks', ['task' => $task->id]) }}" class="btn btn-primary">
                        <i class="glyphicon glyphicon-edit"></i> Edit
                      </a>
                      <button type="submit" id="delete-task-{{ $task->id }}" class="btn btn-danger">
                        <i class="fa fa-btn fa-trash"></i>Delete
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      @endif
    </div>
  </div>
@endsection

@section('javascript')
    <script>
        $('.tags').on('itemAdded', function (event) {
            var taskId = $(this).parents('tr').data('id');
            var tag = event.item;

            $.ajax({
                url: '/api/tasks/'+ taskId +'/tag',
                method: 'POST',
                dataType: 'json',
                data: { tag: tag }
            }).done(function (res) {
                console.log(res);
            });
        });

        $('.tags').on('itemRemoved', function (event) {
            var taskId = $(this).parents('tr').data('id');
            var tag = event.item;

            $.ajax({
                url: '/api/tasks/'+ taskId +'/tag',
                method: 'DELETE',
                dataType: 'json',
                data: { tag: tag }
            }).done(function (res) {
                console.log(res);
            });
        });
    </script>
@endsection

@section('append_scripts')
  <script src="{{ elixir('js/moment.js') }}"></script>
  <script src="{{ elixir('js/bootstrap-datetimepicker.min.js') }}"></script>
  <script type="text/javascript">
  $( document ).ready(function() { // console.log('document-ready!');
    $('[data-toggle="tooltip"]').tooltip(); // 툴팁 작동 (bootstrap)
    $('#due-date').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'}); // 데이터 피커 작동
      // 부트스트랩 데이트 피커 : https://github.com/Eonasdan/bootstrap-datetimepicker/
  });
  </script>
@endsection
