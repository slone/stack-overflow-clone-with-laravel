<div class="media post question-wrapper">
	<div class="d-flex flex-column counters">
		<div class="vote">
			<strong>{{ $question->votes_count }}</strong> <span class="label">{{ Str::plural('vote', $question->votes_count) }}</span>
		</div>
		<div class="status {{ $question->status_text }}">
			<strong>{{ $question->answers_count }}</strong> <span class="label">{{ Str::plural('answer', $question->answers_count) }}</span>
		</div>
		<div class="view">
			{{ $question->views .' '. Str::plural('view', $question->views) }}
		</div>
	</div>
	<div class="media-body">
		<div class="d-flex align-items-center">
			<h3 class="mt-0"><a href="{{ $question->url }}">{{ $question->title }}</a></h3>
			<div class="ml-auto">
				@can('update', $question)
				<a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-outline-info">{{ __('Edit') }}</a>
				@endcan

				@can('delete', $question)
				<form method="post" action="{{ route('questions.destroy', $question->id) }}" class="form-delete">
					@method('DELETE')
					@csrf
					<button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you wish to delete this question?')">{{ __('Delete') }}</button>
				</form>
				@endcan 

			</div>
		</div>
		<p class="lead">
			Asked by <a href="{{$question->user->url}}">{{ $question->user->name }}</a>
			<small class="text-muted">{{ $question->created_date }}</small>
		</p>
		<div class="excerpt"> {{ $question->excerpt }} </div>
	</div>
</div>