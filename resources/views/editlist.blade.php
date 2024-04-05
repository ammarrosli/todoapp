<x-app-layout>
    <x-slot name="header">

    </x-slot>

    @if(session('success'))
        <div class="alert alert-primary" role="alert">
            {{session('success')}}
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- Bootstrap 5 CSS -->
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-o3FU1BB1iMYYhzjWiZ1T8JzgI6OpzcCaCfTP8OpqOBfFO9qitk02s5p/dKaFSKxj" crossorigin="anonymous">

                <div class="container rounded-3 border-dark my-5 bg-white" style="height:auto;">
                    <div>
                        <h1 class="h3">Edit To Do List</h1>
                        <form action="/listtodo/{{$listtodo->id}}/update" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-6">
                                    <input class="py-3 form-control shadow mb-3" name="title" placeholder="Input your task" class="form-control" type="text" id="inputText" value="{{$listtodo->title}}">
                                    <input class="py-3 form-control shadow mb-3" name="description" placeholder="Add Your Description" class="form-control" type="text" id="descriptionText" value="{{$listtodo->description}}">
                                </div>
                                <div class="col-md-2">
                                <input type="datetime-local" name="deadline" id="deadlineInput" class="py-3 form-control shadow mb-3" value="{{ \Carbon\Carbon::parse($listtodo->deadline)->format('Y-m-d\TH:i') }}">
                                    <button type="submit" class="mt-2 btn btn-dark"> Update </button>
                                </div>
                            </div>
                        </form>

                        <div id="error-message" class="alert alert-danger" role="alert" style="display: none;">
                        Please fill all the required fields.
                        </div>
                    </div>
                    <hr>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

<script>

     function validateForm() {
            var title = document.getElementById('inputText').value.trim();
            var description = document.getElementById('descriptionText').value.trim();
            var deadline = document.getElementById('deadlineInput').value.trim();

            // Check if any of the required fields are empty
            if (title === '' || description === '' || deadline === '') {
                document.getElementById('error-message').style.display = 'block';
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }
</script>