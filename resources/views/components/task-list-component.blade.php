<div class="container mt-5">
    <h1 class="mb-4">To-Do List</h1>

    <div class="row">
        <div class="col-md-4">
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="title" class="form-control" placeholder="Nueva tarea" required>
                    <button class="btn btn-primary" type="submit">Agregar</button>
                </div>
                @error('title')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </form>
        </div>

        <div class="col-md-8">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Estado</th>
                            <th>Título</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td class="text-center">
                                    <span span id="badge-{{ $task->id }}"  class="badge {{ $task->status ? 'bg-success' : 'bg-warning' }}">
                                        {{ $task->status ? 'Finalizado' : 'Pendiente' }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="d-inline w-100">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="title" id="title-{{ $task->id }}" value="{{ $task->title }}" class="form-control" required>
                                </td>
                                <td>
                                    <button id="finalizar-btn-{{ $task->id }}" class="btn btn-secondary btn-sm"
                                        onclick="updateStatus({{ $task->id }})"
                                        @if ($task->status == 1) style="display: none;" @endif>
                                        Finalizar
                                    </button>


                                    <button class="btn btn-warning btn-sm me-2" onclick="updateTitle({{ $task->id }})">Actualizar</button>
                                </form>

                                <!-- Botón para eliminar tarea -->
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function updateTitle(taskId) {
        var title = $('#title-' + taskId).val();

        if (title.trim() === "") {
            alert("El título no puede estar vacío.");
            return;
        }
        $.ajax({
            url: '/tasks/' + taskId,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                title: title
            },
            success: function(response) {
                alert('Tarea actualizada exitosamente');
            },
            error: function(xhr, status, error) {
                alert('Hubo un error al actualizar la tarea');
            }
        });
    }

    function updateStatus(taskId) {
        var status = 1;

        $.ajax({
            url: '/tasks/' + taskId,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                status: status
            },
            success: function(response) {
                if (status === 1) {
                    $('#badge-' + taskId).removeClass('bg-warning').addClass('bg-success').text('Finalizado');
                } else {
                    $('#badge-' + taskId).removeClass('bg-success').addClass('bg-warning').text('Pendiente');
                }
                $('#finalizar-btn-' + taskId).hide();
                alert('Tarea actualizada exitosamente');
            },
            error: function(xhr, status, error) {
                alert('Hubo un error al cambiar el estado');
            }
        });
    }
</script>
