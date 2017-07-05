@extends('templates.default')

@section('content')
    <section class="task">
        <div class="container">
            <div class="row">
                <h1>User table</h1>
                <div class="success">

                </div>
                <div class="error">

                </div>
                <form><input type="hidden" name="_token" value="{{ csrf_token() }}"></form>
                <table>
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>User name</th>
                        <th>email</th>
                    </tr>
                    </thead>
                    <tbody id="user-contents">
                    </tbody>
                </table>
            </div>
            <div class="row">
                <form action="" class="col s12">
                    <h3>Add user</h3>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="name" type="text" class="validate">
                            <label for="name">Name</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="email" type="email" class="validate">
                            <label for="email">E-mail</label>
                        </div>
                    </div>
                    <button class="btn waves-effect waves-light green" id="submit-user" type="submit" name="action">Submit
                    </button>
                </form>
            </div>
        </div>
    </section>
@stop

@section('script')

    <script type="text/javascript">
        $(document).ready(function(){
            // alert('JS OK');
            var url = "users";

// GET CONTENT FROM SERVER

            $.get(url, function(data){
                console.log(data);

                var table = '';
                var options = '';

                // ADD USERS IN TBODY

                for(var i = 0; i < data.length; i++){

                    table += '<tr id="user'+data[i]['id']+'">';

                    for(key in data[i]){
                        table += '<td>' + data[i][key] + '</td>';
                    }

                    table += '<td><a class="waves-effect waves-light btn" href="users/'+data[i]['id']+'">tasks</a></td>';
                    table += '<td><a class="waves-effect waves-light btn blue edit-user" href="users/edit/'+data[i]['id']+'">edit</a></td>';
                    table += '<td><button class="waves-effect waves-light btn red delete-user" value="'+data[i]['id']+'">delete</button></td>';
                    table += '</tr>';

                }

                $('#user-contents').append(table);

            });

// END

// DELETE USER AJAX START
            $('#user-contents').on('click', '.delete-user', function(){
                var id = $(this).val();
               deleteContent(false, id, 'user');
            });
//
//END

// ADD USER AJAX START

            $('#submit-user').on('click', function(e){
                e.preventDefault();
                $('.responses').remove();

                var token = $('input[name="_token"]').attr('value');
                var name = $('#name').val();
                var email = $('#email').val();
                var responses;

                $.ajax({

                    method: 'POST',
                    url: url + '/add_user',
                    data: {_token: token, name: name, email: email},

                    success: function(data){
                         console.log(data);
                        var table = '<tr id="user'+data.id+'">';
                        var option = '<option value="'+data.id+'">'+data.name+'</option>';

                        table += '<td>'+ data.id+'</td>';
                        table += '<td>'+ data.name+'</td>';
                        table += '<td>'+ data.email+'</td>';
                        table += '<td><a class="waves-effect waves-light btn" href="users/' + data.id + '">tasks</a></td>';
                        table += '<td><a class="waves-effect waves-light btn blue edit-user" href="users/edit/' + data.id + '">edit</a></td>';
                        table += '<td><button class="waves-effect waves-light btn red delete-user" value="' + data.id + '">delete</button></td>';
                        table += '</tr>';

                        responses = '\<div class="card-panel green darken-1 responses"><span class="white-text">'+data.name.toUpperCase()+'\ has been created</span></div>';

                        $('#name').val('');
                        $('#email').val('');
                        $('tbody').append(table);
                        $('#user').append(option).trigger('contentChanged');
                        $('.success').append(responses).trigger('contentChanged');




                    },

                    error: function(data){
                        console.log(data);
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
            //END

        });
    </script>
@stop