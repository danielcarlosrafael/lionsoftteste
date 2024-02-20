@extends('layout')

@section('content')
    <div class="container mt-4">
        <h2 class="d-flex justify-content-between">
            Categorias de Tarefas
            <a title="Novo" class="btn btn-success ml-auto" href="{{ route('categories.create') }}">Novo</a>
        </h2>

        <div class="table-responsive">
            <table id="categoriesTable" class="table table-bordered">
                <thead>
                <tr>
                    <th>Nome da Categoria</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td class="text-end">
                            <div class="justify-content-end">
                                <a title="Editar" href="{{ route('categories.show', $category->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a title="Remover" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $category->id }}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                        <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" aria-labelledby="deleteModal{{ $category->id }}Label" aria-hidden="true">
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
                                        <a title="Excluir" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $category->id }}').submit();">
                                            Excluir
                                        </a>
                                        <!-- Formulário para executar a exclusão -->
                                        <form id="delete-form-{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: none;">
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
            $('#categoriesTable').DataTable({
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