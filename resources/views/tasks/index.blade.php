@extends('layout')

@section('content')
    <div class="container mt-4">
        <h2 class="d-flex justify-content-between">
            Tarefas
            <a title="Novo" class="btn btn-success ml-auto" href="{{ route('tasks.create') }}">Novo</a>
        </h2>

        <div class="table-responsive">
            <table id="tasksTable" class="table table-bordered">
                <thead>
                <tr>
                    <th>Título</th>
                    <th>Nome da Categoria</th>
                    <th>Finalizada</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->category->name ?? '-' }}</td>
                        <td>{{ $task->completed == 'y' ? 'Sim' : 'Não' }}</td>
                        <td class="text-end">
                            <div class="justify-content-end">
                                <a title="Editar" href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a title="Remover" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $task->id }}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                        <div class="modal fade" id="deleteModal{{ $task->id }}" tabindex="-1" aria-labelledby="deleteModal{{ $task->id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirmar exclusão</h5>
                                        <button title="Fechar" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Você tem certeza que deseja excluir esta categoria?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button title="Canceçar" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <!-- Botão para executar a exclusão após a confirmação -->
                                        <a title="Excluir" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $task->id }}').submit();">
                                            Excluir
                                        </a>
                                        <!-- Formulário para executar a exclusão -->
                                        <form id="delete-form-{{ $task->id }}" action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#tasksTable').DataTable({
                language: {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    },
                    "select": {
                        "rows": {
                            "_": "Selecionado %d linhas",
                            "0": "Nenhuma linha selecionada",
                            "1": "Selecionado 1 linha"
                        }
                    }
                }
            });
        });
    </script>
@endsection