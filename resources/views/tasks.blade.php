@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card card-new-task mb-5">
                <div class="card-header font-weight-bold">New Task</div>

                <div class="card-body">
                    <form id="card-form" method="POST" action="{{ route('tasks.store') }}">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input id="title" name="title" type="text" maxlength="255" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" autocomplete="off" />
                            @if ($errors->has('title'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary card-submit">Create</button>
                        <button type="button" class="btn btn-secondary card-cancel d-none" onclick="toggleCancel()">Cancel</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header font-weight-bold">Tasks</div>

                <div class="card-body">
                   <table class="table table-striped">
                       @foreach ($tasks as $task)
                           <tr>
                               <td>
                                   @if ($task->is_done)
                                       <s>{{ $task->title }}</s>
                                   @else
                                       {{ $task->title }}
                                   @endif
                               </td>
                               <td class="d-flex justify-content-end align-items-start">
                                    @if (! $task->is_done)
                                        <button type="button" class="btn btn-primary mr-1" onClick="toggleForm({{ $task }})">Edit</button>
                                        <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success mr-1">Done</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('tasks.destroy', $task->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                               </td>
                           </tr>
                       @endforeach
                   </table>

                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>

function toggleForm(task)
{
    var topCard = document.querySelector('.card-new-task')
    var cardHeader = topCard.querySelector('.card-header')
    var cardForm = topCard.querySelector('#card-form')
    var cardMethod = cardForm.querySelector('[name="_method"]')
    var cardTitle = topCard.querySelector('#title')
    var cardSubmit = topCard.querySelector('.card-submit')
    var cardCancel = topCard.querySelector('.card-cancel')

    cardHeader.innerHTML = 'Update Task'
    cardTitle.value = task.title
    cardForm.action = `/tasks/${task.id}/update`
    cardMethod.value = 'PATCH'
    cardSubmit.innerHTML = 'Update'
    cardCancel.classList.remove("d-none")
}

function toggleCancel()
{
    var topCard = document.querySelector('.card-new-task')
    var cardHeader = topCard.querySelector('.card-header')
    var cardForm = topCard.querySelector('#card-form')
    var cardMethod = cardForm.querySelector('[name="_method"]')
    var cardTitle = topCard.querySelector('#title')
    var cardSubmit = topCard.querySelector('.card-submit')
    var cardCancel = topCard.querySelector('.card-cancel')

    cardHeader.innerHTML = 'New Task'
    cardTitle.value = ''
    cardForm.action = '/tasks'
    cardMethod.value = 'POST'
    cardSubmit.innerHTML = 'Create'
    cardCancel.classList.add("d-none")
}

</script>
