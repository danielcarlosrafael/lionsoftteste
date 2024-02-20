@extends('layout')

@section('content')

    <div class="container mt-4">
        <h2>Formulário de Categoria</h2>

        <form method="POST" action="{{isset($item) ? route("categories.update",$item->id) : route("categories.store") }}">
            @csrf
            @if(isset($item))
                @method('PUT')
            @endif
            <div class="form-group">
                <label for="name">Nome da Categoria *</label>
                <input
                    type="text"
                    class="form-control"
                    id="name"
                    name="name"
                    required
                    value="{{ isset($item) ? $item->name : '' }}"
                    maxlength="200">
            </div>

            <div class="form-group">
                &nbsp;
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-primary" title="{{ isset($item) ? 'Editar' : 'Cadastrar' }}">
                    {{ isset($item) ? 'Editar' : 'Cadastrar' }}
                </button>
                &nbsp;
                <a href="{{ route('categories.index') }}" class="btn btn-secondary" title="Voltar">Voltar</a>
            </div>
        </form>
    </div>
@endsection