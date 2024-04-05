<x-app-layout>
    <x-slot name="header">
    
    </x-slot>

    @if(session('success'))
        <div class="alert alert-primary" role="alert">
            {{session('success')}}
        </div>

        @if(session('hideMessageAfter'))
      <script>
         setTimeout(function() {
            document.querySelector('.alert').style.display = 'none';
         }, {{ session('hideMessageAfter') * 1000 }});
      </script>
        @endif
    @endif
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="row mb-3">
                <div class="col">
                    <button class="btn btn-dark" onclick="filterTasks('all')">All</button>
                    <button class="btn btn-dark" onclick="filterTasks('active')">Active</button>
                    <button class="btn btn-dark" onclick="filterTasks('completed')">Completed</button>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- Bootstrap 5 CSS -->
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-o3FU1BB1iMYYhzjWiZ1T8JzgI6OpzcCaCfTP8OpqOBfFO9qitk02s5p/dKaFSKxj" crossorigin="anonymous">

                <div class="container rounded-3 border-dark my-5 bg-white" style="height:auto;">
                    <div>
                        <h1 class="h3">To Do List</h1>
                        <form action="{{url('listtodo')}}" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-6">
                                <input class="py-3 form-control shadow mb-3" name="title" placeholder="Input your task" class="form-control" type="text" id="inputText" class="invalid-feedback">
                                <input class="py-3 form-control shadow mb-3" name="description" placeholder="Add Your Description" class="form-control" type="text" id="descriptionText" class="invalid-feedback">
                            </div>
                            <div class="col-md-2">
                                <input type="datetime-local" name="deadline" id="deadlineInput" class="py-3 form-control shadow mb-3">
                                
                                <button type="submit" class="mt-2 btn btn-dark" id="addButton"> Add </button>
                            </div>
                        </div>
                    </form>

                    <div id="error-message" class="alert alert-danger" role="alert" style="display: none;">
                        Please fill all the required fields.
                    </div>
                    </div>
                    <hr>
                    
                    <div class="row rounded bg-white">
                        <div class="col-12">
                            <ul class="list-group" id="list">
                                @foreach($listtodo as $list)
                                <li class="my-3 py-3 shadow list-group-item" data-status="{{ $list->completed ? 'completed' : 'active' }}">
                                    <div class="row">
                                        <div class="col-5">
                                        <input type="checkbox" class="form-check-input" id="checkbox{{$loop->index}}"  onclick="toggleTaskStatus({{$loop->index}})" {{$list->completed ? 'checked' : ''}}>
                                            <label class="form-check-label {{$list->completed ? 'crossed-out' : ''}}" for="checkbox{{$loop->index}}" style="font-weight: bold;">{{$list->title}}</label>
                                            <p class="text-muted">{{$list->description}}</p>
                                        </div>
                                        <div class="col-3">
                                            <span>{{$list->deadline}}</span>
                                        </div>
                                        <div class="col-3">
                                            <span class="badge {{$list->completed ? 'bg-success' : 'bg-primary'}}" id="badge{{$loop->index}}">
                                                {{$list->completed ? 'Done' : 'In Progress'}}
                                            </span>
                                            <a class="btn btn-dark edit-button" href="/listtodo/{{$list->id}}/edit">Edit</a>
                                            <a class="btn btn-dark" href="/listtodo/{{$list->id}}/delete" onclick="return confirm('Are you sure want to delete?')">Delete</a>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>

<style>
    .crossed-out {
        text-decoration: line-through;
    }
</style>

<script>

    function validateForm() {
            var title = document.getElementById('inputText').value.trim();
            var description = document.getElementById('descriptionText').value.trim();
            var deadline = document.getElementById('deadlineInput').value.trim();

            
            if (title === '' || description === '' || deadline === '') {
                document.getElementById('error-message').style.display = 'block';
                return false; 
            }

            return true; 
        }

    function crossOutTask(index) {
        var label = document.querySelector('label[for="checkbox'+index+'"]');
        label.classList.toggle('crossed-out');

        var listItem = label.closest('.list-group-item');
        var checkbox = listItem.querySelector('#checkbox'+index);

        if (label.classList.contains('crossed-out')) {
            listItem.setAttribute('data-status', 'completed');
        } else {
            listItem.setAttribute('data-status', 'active');
        }

        // Check if checkbox is checked
        if (checkbox.checked) {
            filterTasks('completed'); // Move to "completed" category
        } else {
            filterTasks('all'); // Show all tasks
        }
    }
    
    function filterTasks(category) {
        const tasks = document.querySelectorAll('.list-group-item');
        
        tasks.forEach(task => {
            const status = task.getAttribute('data-status');
            
            if (category === 'all' || status === category) {
                task.style.display = 'block';
            } else {
                task.style.display = 'none';
            }
        });
    }

    function toggleTaskStatus(index) {
        var label = document.querySelector('label[for="checkbox' + index + '"]');
        label.classList.toggle('crossed-out');

        var listItem = label.closest('.list-group-item');
        var checkbox = listItem.querySelector('#checkbox' + index);
        var badge = listItem.querySelector('#badge' + index);
        var editButton = listItem.querySelector('.edit-button');

        if (label.classList.contains('crossed-out')) {
            listItem.setAttribute('data-status', 'completed');
            badge.classList.remove('bg-primary');
            badge.classList.add('bg-success');
            badge.textContent = 'Done';
            // Hide edit and delete buttons
            editButton.style.display = 'none';

        } else {
            listItem.setAttribute('data-status', 'active');
            badge.classList.remove('bg-success');
            badge.classList.add('bg-primary');
            badge.textContent = 'In Progress';
            // Show edit and delete buttons
            editButton.style.display = 'inline-block';

        }

        if (checkbox.checked) {
            filterTasks('completed'); // Move to "completed" category
        } else {
            filterTasks('all'); // Show all tasks
        }
    }

</script>