@if ($answersCount > 0) 
<div class="row mt-4 justify-content-center answers-wrapper">
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<div class="card-title">
					<h2> {{ $answersCount . ' ' . Str::plural('Answer', $answersCount) }} </h2>
				</div>
				<hr>
				@include ('layouts._messages')

				@foreach ($answers as $answer) 

					<div class="media answer-wrapper">
						<div class="row">

							@include('shared._vote-controls', [
								'model' => $answer,
							])

							<div class="media-body">
							{!! $answer->body_html !!}


							<footer class="row answer-infos">
								<div class="col-4 owner-controls">
	
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
								<div class="col-3"></div>
								<div class="col-5">
	
									@include('shared._author', [
										'model' => $answer,
										'label' => 'answered'
									])
									
								</div>
							</footer>
	

							</div>


						</div>
					</div>
					<hr>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endif
