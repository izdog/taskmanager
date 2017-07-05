@extends('templates.default')

@section('content')
    <section class="user">
        <div class="container">
            <div class="row">
                <h1>Edit User</h1>
                <h3 id="username"></h3>
                <div class="success">

                </div>
                <div class="error">

                </div>
                <form action="" class="col s12">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                    <div class="submit-buttons" style="display: flex; justify-content: space-between">
                        <button class="btn waves-effect waves-light green" id="edit-user" type="submit" name="action">Submit
                    </div>
                    </button>
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


            $.get('/usersEdit/' + id, function(data){
                console.log(data);

                $('.submit-buttons').append('<button class="waves-effect waves-light btn red delete-user" value="' + data.id + '">delete user</button>');
                $('#name').val(data.name).siblings('label').addClass('active');
                $('#email').val(data.email).siblings('label').addClass('active');
            });

            $('#edit-user').on('click', function(e){
                e.preventDefault();

                var token = $('input[name="_token"]').attr('value');
                var name = $('#name').val();
                var email = $('#email').val();
                var responses;

                $.ajax({

                    method: 'put',
                    url: '/users/update/'+ id,
                    data: {_token: token, name: name, email: email},
                    success: function(data){
                        console.log(data);

                        responses = '<div class="card-panel green darken-1 responses"><span class="white-text">User has been modified</span></div>';

                        for(key in data){
                            if(key == 'error'){
                                responses = '<div class="card-panel red darken-1 responses"><span class="white-text">' + data.error + '</span></div>';
                            }
                        }

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

            $('.submit-buttons').on('click', '.delete-user', function(e){
                e.preventDefault();
               deleteContent('userView', id, 'user');
            });

        });
    </script>
@endsection