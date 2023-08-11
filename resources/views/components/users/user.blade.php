@extends('home')

@section('components')
    <div class="card">
        <div class="card-header">{{ __('Listado de Usuarios') }}</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="container">
                <table id="user-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @include('components.users.form')
    <script>
        $(document).ready(function() {
            var table = $('#user-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: null,
                        class: 'd-flex justify-content-center',
                        render: function(data, type, row) {
                            return '<button class="btn btn-primary edit-btn mx-2" data-id="' + data.id +
                                '">Editar</button>' +
                                '<button class="btn btn-danger delete-btn" data-id="' + data.id +
                                '">Eliminar</button>';
                        }
                    }
                ]
            });

            // Manejar clic en el botón de editar
            $('#user-table tbody').on('click', '.edit-btn', function() {
                var userId = $(this).data('id');

                // Hacer una solicitud AJAX para obtener la información del usuario
                $.get("{{ route('users.show', '') }}/" + userId, function(resp) {
                    var user = resp.user
                    // Llenar el modal con la información del usuario
                    $('#editModal #editForm input[name="id"]').val(user.id);
                    $('#editModal #editForm input[name="name"]').val(user.name);
                    $('#editModal #editForm input[name="email"]').val(user.email);
                    $('#editModal #editForm input[name="birthdate"]').val(user.birthdate);
                    $('#editModal #editForm input[name="city"]').val(user.city);
                    $('#editModal #editForm input[name="address"]').val(user.address);
                    // Mostrar el modal de edición
                    $('#editModal').modal('show');
                });
            });

            // Manejar clic en el botón de eliminar
            $('#user-table tbody').on('click', '.delete-btn', function() {
                var userId = $(this).data('id');

                // Confirmar la eliminación
                if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
                    // Realizar la solicitud AJAX para eliminar el usuario
                    $.ajax({
                        url: "{{ route('users.destroy', '') }}/" + userId,
                        type: "DELETE",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // Recargar la tabla de usuarios después de eliminar
                            showAlert(response.message, 'success');
                            table.ajax.reload();

                        }
                    });
                }
            });

            $('#saveChanges').on('click', function() {
                var userId = $('#editModal #editForm input[name="id"]').val();
                var name = $('#editModal #editForm input[name="name"]').val();
                var email = $('#editModal #editForm input[name="email"]').val();
                var birthdate = $('#editModal #editForm input[name="birthdate"]').val();
                var city = $('#editModal #editForm input[name="city"]').val();
                var address = $('#editModal #editForm input[name="address"]').val();

                var userData = {
                    name: name,
                    email: email,
                    birthdate: birthdate,
                    city: city,
                    address: address
                };

                // Enviar los datos actualizados del usuario al servidor
                $.ajax({
                    url: "{{ route('users.update', '') }}/" + userId,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "PUT",
                    data: userData,
                    success: function(response) {
                        // Cerrar el modal y recargar la tabla de usuarios
                        $('#editModal').modal('hide');
                        showAlert(response.message, 'success');
                        table.ajax.reload(); // "table" should be the DataTables instance
                    }
                });
            });
        });
        function showAlert(message, type) {
            var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
                message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>' +
                '</div>';

            $('#alerts-container').html(alertHtml);
        }
    </script>
@endsection
