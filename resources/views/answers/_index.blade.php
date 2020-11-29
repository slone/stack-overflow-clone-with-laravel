<div class="row mt-4 justify-content-center">
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<div class="card-title">
					<h2> {{ $answersCount . ' ' . Str::plural('Answer', $answersCount) }} </h2>
				</div>
				<hr>
				@include ('layouts._messages')

				@foreach ($answers as $answer) 

					<div class="media">
						<div class="d-flex flex-column vote-controls">


							<a title="this answer is useful" 
								class="vote-up {{ (Auth::guest() ? 'off' : '') }} "
								onclick="event.preventDefault(); document.getElementById('up-vote-answer-{{ $answer->id }}').submit();">
								<i class="fas fa-caret-up fa-2x"></i>
							</a>
							<form id="up-vote-answer-{{ $answer->id }}" action="/answers/{{ $answer->id }}/vote" method="post">
								@csrf
								<input type="hidden" value="1" name="vote" />
							</form>							
							<span class="votes-count">{{ $answer->votes_count }}</span>
							<a title="this answer is not useful" 
								class="vote-down {{ (Auth::guest() ? 'off' : '') }}"
								onclick="event.preventDefault(); document.getElementById('down-vote-answer-{{ $answer->id }}').submit();">
								<i class="fas fa-caret-down fa-2x"></i>
							</a>
							<form id="down-vote-answer-{{ $answer->id }}" action="/answers/{{ $answer->id }}/vote" method="post">
								@csrf
								<input type="hidden" value="-1" name="vote" />
							</form>							




						@can('accept', $answer)
							<a title="Mark as best answer" 
								class="{{ $answer->status }} mt-2"
								onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $answer->id }}').submit();">
								<i class="fas fa-check fa-2x"></i>
							</a>

							<form id="accept-answer-{{ $answer->id }}" method="post" action="{{ route('answers.accept', $answer->id) }}" style="display: none">
								@csrf
							</form>
						@else
							@if ($answer->is_best)
							<a title="The question owner accepted this answer" class="{{ $answer->status }} mt-2">
								<i class="fas fa-check fa-2x"></i>
							</a>
							@endif
						@endcan
						</div>

						<div class="media-body">
						{!! $answer->body_html !!}
						</div>

						</div>
						<div class="row">
							<div class="col-4">
								<div class="ml-auto">
									@can('update', $answer)
									<a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}" class="btn btn-sm btn-outline-info">{{ __('Edit') }}</a>
									@endcan

									@can('delete', $answer)
									<form method="post" action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}" class="form-delete">
										@method('DELETE')
										@csrf
										<button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you wish to delete this question?')">{{ __('Delete') }}</button>
									</form>
									@endcan 
								</div>
							</div>
							<div class="col-4"></div>
							<div class="col-4">
								<span class="text-muted">Answered {{ $answer->created_at }}</span>
								<div class="media mt-2">
									<a href="{{ $answer->user->url }}" class="pr-2">
										<img src="{{ $answer->user->avatar }}" alt="avatar of {{ $answer->user->name }}">
									</a>
									<div class="media-body mt-1">
										<a href="{{ $answer->user->url }}">{{ $answer->user->name }}</a>
									</div>
								</div>
							</div>
						</div>
					<hr>
				@endforeach
			</div>
		</div>
	</div>
</div>
