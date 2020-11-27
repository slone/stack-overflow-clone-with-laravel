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
							<a title="this question is useful" class="vote-up">
								<i class="fas fa-caret-up fa-2x"></i>
							</a>
							<span class="votes-count">
								1224
							</span>
							<a title="this question is not useful" class="vote-down off">
								<i class="fas fa-caret-down fa-2x"></i>
							</a>
							<a title="Click to favorite the question - click again to undo" class="favorite mt-2 favorited">
								<i class="fas fa-star"></i>
							</a>
							<span class="favorites-count">
								54
							</span>
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
