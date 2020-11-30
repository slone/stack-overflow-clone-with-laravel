@php 
	$is_question 	= $model instanceof App\Models\Question; 
	$is_answer 		= $model instanceof App\Models\Answer; 
	if ($is_question) 	$subjectName = 'question';
	if ($is_answer) 	$subjectName = 'answer';
	$route = $subjectName.'s';
	$formIdSuffix = $subjectName.'-'.$model->id;
	$formActionURI = '/'. $route .'/'. $model->id .'/vote';
@endphp


<div class="d-flex flex-column vote-controls">

	<a title="this {{ $subjectName }} is useful" 
		class="vote-up {{ (Auth::guest() ? 'off' : '') }} "
		onclick="event.preventDefault(); document.getElementById('up-vote-{{ $formIdSuffix }}').submit();">
		<i class="fas fa-caret-up fa-2x"></i>
	</a>
	<form id="up-vote-{{ $formIdSuffix }}" action="{{ $formActionURI }}" method="post">
		@csrf
		<input type="hidden" value="1" name="vote" />
	</form>	

	<span class="votes-count">{{ $model->votes_count }}</span>
	
	<a title="this {{ $subjectName }} is not useful" 
		class="vote-down {{ (Auth::guest() ? 'off' : '') }}"
		onclick="event.preventDefault(); document.getElementById('down-vote-{{ $formIdSuffix }}').submit();">
		<i class="fas fa-caret-down fa-2x"></i>
	</a>
	<form id="down-vote-{{ $formIdSuffix }}" action="{{ $formActionURI }}" method="post">
		@csrf
		<input type="hidden" value="-1" name="vote" />
	</form>							

	@if ($is_question) 
	<favorite-button :question="{{ $model }}"></favorite-button>

	@elseif ($is_answer)
	<accept-button :answer="{{ $model }}"></accept-button>
	@endif
</div>
