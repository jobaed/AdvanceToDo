@extends('Frontend.layout.sidenav-layout')
@section('content')
    @include('Frontend.component.todo.todo-create')
    @include('Frontend.component.todo.todo-delete')
    @include('Frontend.component.todo.todo-list')
    @include('Frontend.component.todo.todo-update')
    @include('Frontend.component.todo.completedModal')
@endsection