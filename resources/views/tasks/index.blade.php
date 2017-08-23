@extends('layouts.app')

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
            <form action="{{ url('task') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}


            <!-- Task Name -->
              <div class="form-group">
                <label for="task-name" class="col-sm-3 control-label">Task</label>
                <div class="col-sm-6">
                  <input type="text" name="name" id="task-name" class="form-control" value="{{ old('task') }}">
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
                <tr>
                  <td class="table-text"><div><span>{{ $task->getFormattedDate($task) }}</span> {{ $task->name }}</div></td>


                  <!-- Task Delete Button -->
                  <td>


                    <form action="{{url('task/' . $task->id)}}" method="POST">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <a href="{{ url('task',['task' => $task->id])}}" class="btn btn-primary">
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
