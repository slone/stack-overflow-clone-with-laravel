@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-body p1">
					<div class="card-title">
						<div class="d-flex align-items-center">
							<h1>{{ $question->title }}</h1>
							<div class="ml-auto">
								<a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">{{ __('Back to all questions')}}</a>
							</div>
						</div>
					</div>

					<hr>

					<div class="media">
						<div class="d-flex flex-column vote-controls">


							<a title="this question is useful" 
								class="vote-up {{ (Auth::guest() ? 'off' : '') }} "
								onclick="event.preventDefault(); document.getElementById('up-vote-question-{{ $question->id }}').submit();">
								<i class="fas fa-caret-up fa-2x"></i>
							</a>
							<form id="up-vote-question-{{ $question->id }}" action="/questions/{{ $question->id }}/vote" method="post">
								@csrf
								<input type="hidden" value="1" name="vote" />
							</form>							
							<span class="votes-count">{{ $question->votes_count }}</span>
							<a title="this question is not useful" 
								class="vote-down {{ (Auth::guest() ? 'off' : '') }}"
								onclick="event.preventDefault(); document.getElementById('down-vote-question-{{ $question->id }}').submit();">
								<i class="fas fa-caret-down fa-2x"></i>
							</a>
							<form id="down-vote-question-{{ $question->id }}" action="/questions/{{ $question->id }}/vote" method="post">
								@csrf
								<input type="hidden" value="-1" name="vote" />
							</form>							





							<a title="Click to favorite the question - click again to undo" 
								class="favorite mt-2 {{ ( Auth::guest() ? 'off' : ($question->is_favorited ? 'favorited' : '' ) ) }}"
								onclick="event.preventDefault(); document.getElementById('favorite-question-{{ $question->id }}').submit();">
								<i class="fas fa-star fa-2x"></i>
							</a>
							<form id="favorite-question-{{ $question->id }}" action="/questions/{{ $question->id }}/favorites" method="post">
								@csrf
								@if ($question->is_favorited)
									@method('DELETE')
								@endif
							</form>
							<span class="favorites-count">{{ $question->favorites_count }}</span>



						</div>
						<div class="media-body">
							<div>{!! $question->body_html !!}</div>
							<div class="float-right">
								<span class="text-muted">Asked {{ $question->created_at }}</span>
								<div class="media mt-2">
									<a href="{{ $question->user->url }}" class="pr-2">
										<img src="{{ $question->user->avatar }}" alt="avatar of {{ $question->user->name }}">
									</a>
									<div class="media-body mt-1">
										<a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('answers._index', [
		'answers' => $question->answers,
		'answersCount' => $question->answers_count
	])
	@include('answers._create')
</div>
@endsection
