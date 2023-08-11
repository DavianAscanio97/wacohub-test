@extends('home')

@section('components')
    <div class="card">
        <div class="card-header">{{ __('Listado de Pokemon') }}</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="container">
                <table id="pokemon-table" class="table">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Favoritos</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @include('components.users.form')
    <script>
        $(document).ready(function() {
           var table = $('#pokemon-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ route('pokemon.index') }}",
                columns: [
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return '<img src="' + data + '" alt="' + full.name + '" width="50" height="50">';
                        }
                    },
                    { data: 'name', name: 'name', class:'w-50'},
                    {
                        data: 'actions',
                        name: 'actions',
                        class: 'd-flex justify-content-end',
                        orderable: false,
                        searchable: false,
                         render: function(data, type, full, meta) {
                            var buttonText = data.isFavorited ? 'Remover de favoritos' : 'Agregar a favoritos';
                            var iconClass = data.isFavorited ? 'fas fa-star' : 'far fa-star';
                            var colorButton = data.isFavorited ? 'btn-warning color-danger' : 'btn-danger color-white';

                            return '<form method="post" action="' + data.actionUrl + '">' +
                                '<input type="hidden" name="pokemon_name" value="' + data.pokemonName + '">' +
                                '<button type="submit" class="btn ' + colorButton + ' btn-favorite" data-toggle="tooltip" title="' + buttonText + '">' +
                                '<i class="' + iconClass + '"></i> ' + buttonText +
                                '</button>' +
                                '</form>';
                        }
                    }
                ]
            });

            $(document).on('click', '.btn-favorite', function(e) {
                e.preventDefault();

                var form = $(this).closest('form');
                 $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Check if the Pokémon is favorited
                        var isFavorited = response.is_favorited; // Modify based on your response structure

                        // Update the button text based on the favorite status
                        if (isFavorited) {
                            form.find('.btn-favorite').text('Remove from Favorites');
                        } else {
                            form.find('.btn-favorite').text('Add to Favorites');
                        }

                        // Show success message
                        if (response.message) {
                            alert(response.message);
                            table.ajax.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred while updating the favorite status.');
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
