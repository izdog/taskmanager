@extends('templates.default')

@section('content')
    <section class="user">
        <div class="container">
            <div class="row">
                <h1>Edit Task</h1>
                <div class="success">

                </div>
                <div class="error">

                </div>
            </div>
            <div class="row">
                <form action="" class="col s12">
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="title" type="text" class="validate">
                            <label for="title">Title</label>
                        </div>
                        <div class="input-field col s6">
                            <select name="user" id="users">
                                {{--<option value="" disabled selected>Choose your user</option>--}}
                            </select>
                            <label for="user">User</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <textarea id="description" class="materialize-textarea"></textarea>
                            <label for="description">Description</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="status" type="text" class="validate">
                            <label for="status">Status</label>
                        </div>
                    </div>
                    <div class="submit-buttons" style="display: flex; justify-content: space-between">
                        <button class="btn waves-effect waves-light green" id="edit-task" type="submit" name="action">Submit
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            var url = window.location.href;
            var id = url.split(/[/ ]+/).pop();

//            GET CONTENT START

            $.get('/tasksEdit/'+ id, function(data){
               console.log(data);
                var task = data.task;
                var users = data.users;
                var options = '';

                $('.submit-buttons').append('<button class="waves-effect waves-light btn red delete-task" value="' + task.id + '">delete task</button>');
                $('#title').val(task.title).siblings('label').addClass('active');
                $('#description').val(task.description).siblings('label').addClass('active');
                $('#status').val(task.status).siblings('label').addClass('active');

                if(task['user_id'] === null ){
                    options += '<option value="" disabled selected>Choose your user</option>';
                }

                for(var i = 0; i < users.length; i++ ){
                    if(users[i]['id'] === task['user_id']){
                        options += '<option value="' + users[i]['id'] + '" selected>' + users[i]['name'] + '</option>';
                    } else {
                        options += '<option value="' + users[i]['id'] + '">' + users[i]['name'] + '</option>'
                    }
                }

                $('#users').append(options).trigger('contentChanged');

            });

//            GET CONTENT END


//            UPDATE TASK START

            $('#edit-task').on('click', function(e){
               e.preventDefault();

                var token = $('input[name="_token"]').attr('value');
                var title = $('#title').val();
                var description = $('#description').val();
                var user_id = $('#users').val();
                var status = $('#status').val();
                var responses;

                $.ajax({
                   method: 'put',
                    url: '/tasks/update/' + id,
                    data: {_token: token, title: title, description: description, user_id: user_id, status: status},

                    success: function(data){
                        console.log(data);
                        responses = '<div class="card-panel green darken-1 responses"><span class="white-text">Task has been modified</span></div>';
                        $('.success').append(responses).trigger('contentChanged');
                    },

                    error: function(data){
                        console.log(data);
                        data = data['responseText'].replace(/\[/g, '');
                        data = data.replace(/]/g, '');
                        data = JSON.parse(data);

                        responses = '\<div class="card-panel red darken-1 responses">';
                        for(key in data){
                            responses += '\<p><span class="white-text">'+data[key]+'\</span></p>';
                        }
                        responses += '\</div>';
                        $('.error').append(responses);
                    }

                });

            });

//            UPDATE TASK END

//            DELETE TASK START

            $('.submit-buttons').on('click', '.delete-task', function(e){
                e.preventDefault();
               var id = $(this).val();
                deleteContent('taskView', id, 'tasks');
            });

//            DELETE TASK END
        });
    </script>
@endsection