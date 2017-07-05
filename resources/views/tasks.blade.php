@extends('templates.default')

@section('content')
    <section class="task">
        <div class="container">
            <div class="row">
                <h1>Tasks table</h1>
                <div class="success">

                </div>
                <div class="error">

                </div>
                <form><input type="hidden" name="_token" value="{{ csrf_token() }}"></form>
                <table>
                    <thead>

                    </thead>
                    <tbody id="tasks-contents">
                    </tbody>
                </table>
            </div>
            <div class="row">
                <form action="" class="col s12">
                    <h3>Create task</h3>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="title" type="text" class="validate">
                            <label for="title">Title</label>
                        </div>
                        <div class="input-field col s6">
                            <select name="user" id="users">
                                <option value="" disabled selected>Choose your user</option>
                            </select>
                            <label for="user">User</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="description" class="materialize-textarea"></textarea>
                            <label for="description">Description</label>
                        </div>
                    </div>
                    <button class="btn waves-effect waves-light green" id="submit-task" type="submit" name="action">Submit
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){

//            GET CONTENT START

           $.get('tasksAll', function(data){
               console.log(data);



               var options = '';
               var tasksWithUser = data.tasksWithUser;
               var tasksWithoutUser = data.tasksWithoutUser;
               var users = data.users;


               for(var i = 0; i < users.length; i++){
                    options += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
               }

               var content = createTableTask(tasksWithUser, true);
               var contentWithoutUser = createTableTask(tasksWithoutUser, false, true);

               $('thead').append(content.thead);
               $('#users').append(options).trigger('contentChanged');
               $('#tasks-contents').append(contentWithoutUser.tbody);
               $('#tasks-contents').append(content.tbody);

           });

//            GET CONTENT END



//            DELETE TASKS START

            $('#tasks-contents').on('click', '.delete-task', function(){
                var task_id = $(this).val();
                deleteContent(false, task_id, 'tasks');
            });

//            DELETE TASKS END

//            CREATE TASK START

            $('#submit-task').on('click', function(e){
                e.preventDefault();

                var token = $('input[name="_token"]').attr('value');
                var title = $('#title').val();
                var description = $('#description').val();
                var user = $('#users').val();
                var username = $('.select-dropdown').val();
                var responses = '';

                console.log(user, title, description);

                $.ajax({
                    method: 'POST',
                    url:'tasks/add_task',
                    data: {_token: token, title: title, description: description, user_id: user},

                    success: function(data){
                        console.log(data);
                        var content = createTableTask(data, false, false);
                        responses = '<div class="card-panel green darken-1 responses"><span class="white-text">Task has been added</span></div>';

                        $('#tasks-contents').append(content.tbody);
                        $('#tasks-contents tr:last-child td:nth-child(6)').append(username);
                        $('.success').append(responses).trigger('contentChanged');

                    },

                    error: function(data){
                        data = data['responseText'].replace(/\[/g, '');
                        data = data.replace(/]/g, '');
                        data = JSON.parse(data);

                        responses += '\<div class="card-panel red darken-1 responses">';
                        for(key in data){
                            responses += '\<p><span class="white-text">'+data[key]+'\</span></p>';
                        }
                        responses += '\</div>';
                        $('.error').append(responses);
                    }
                });
            });


//            CREATE TASK END
        });
    </script>
@endsection