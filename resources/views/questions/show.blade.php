@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center question-wrapper">
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
						@include('shared._vote-controls', [
							'model' => $question,
						])
						<div class="media-body">
							{!! $question->body_html !!}
							<div class="row">
								<div class="col-4"></div>
								<div class="col-3"></div>
								<div class="col-5">
									<user-info :model="{{ $question }}" label="{{ __('asked') }}"></user-info>
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
