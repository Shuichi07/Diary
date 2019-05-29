@extends('layout')

@section('title')
	My Page
@endsection

@section('content')
	<a href="{{ route('diary.create') }}" class="btn btn-outline-primary">新規登録</a>
	@foreach($diaries as $diary)
		<div class="m-4 p-4 border border-primary">
			<p>{{ $diary['title'] }}</p>
			<p>{{ $diary['body'] }}</p>
			<p>{{ $diary['created_at'] }}</p>

			@if(Auth::check() && Auth::user()->id == $diary['user_id'])
			<a class="btn btn-outline-success" href="{{ route('diary.edit', ['id' => $diary['id']]) }}"><i class="fas fa-edit"></i></a>

			<form action="{{ route('diary.destroy', ['id' => $diary['id']])}}" method="POST" class="d-inline">
				@csrf
				@method('delete')
				<button class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i></button>
			</form>
			@endif

		</div>
	@endforeach
@endsection