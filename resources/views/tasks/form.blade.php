@extends('layout')

@section('content')

    <div class="container mt-4">
        <h2>Formulário de Tarefas</h2>

        <form method="POST" action="{{isset($item) ? route("tasks.update",$item->id) : route("tasks.store") }}">
            @csrf
            @if(isset($item))
                @method('PUT')
            @endif
            <div class="form-group">
                <label for="title">Título *</label>
                <input
                    type="text"
                    class="form-control"
                    id="title"
                    name="title"
                    required
                    value="{{ isset($item) ? $item->title : '' }}"
                    maxlength="200">
            </div>

            <div class="form-group">
                &nbsp;
            </div>

            <div class="form-group">
                <label for="title">Descrição *</label>
                <textarea id="description" name="description" class="form-control" required>{{ isset($item) ? $item->description : '' }}</textarea>
            </div>

            <div class="form-group">
                &nbsp;
            </div>

            <div class="form-group">
                <label for="category_id">Categoria</label>
                <select name="category_id" id="category_id" class="form-control">
                    <option value="">Selecione</option>
                    @foreach($categories as $category)
                        <option
                         {{ isset($item) && $item->category_id == $category->id ? 'selected' : '' }}
                         value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                &nbsp;
            </div>

            <div class="form-group">
                <label for="completed">Finalizada *</label>
                <select name="completed" id="completed" class="form-control" required>
                    <option value="">Selecione</option>
                    <option value="y"{{ isset($item) && $item->completed == 'y' ? 'selected' : '' }}>Sim</option>
                    <option value="n"{{ isset($item) && $item->completed == 'n' ? 'selected' : '' }}>Não</option>
                </select>
            </div>

            <div class="form-group">
                &nbsp;
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" title="{{ isset($item) ? 'Editar' : 'Cadastrar' }}">
                    {{ isset($item) ? 'Editar' : 'Cadastrar' }}
                </button>
                &nbsp;
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary" title="Voltar">Voltar</a>
            </div>
        </form>
    </div>
@endsection