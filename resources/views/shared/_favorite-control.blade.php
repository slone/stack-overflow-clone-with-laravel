<a title="Click to favorite the {{ $subjectName }} - click again to undo" class="favorite mt-2 {{ ( Auth::guest() ? 'off' : ($model->is_favorited ? 'favorited' : '' ) ) }}" onclick="event.preventDefault(); document.getElementById('favorite-{{ $subjectName }}-{{ $model->id }}').submit();">
	<i class="fas fa-star fa-2x"></i>
</a>

<form id="favorite-{{ $subjectName }}-{{ $model->id }}" action="/{{ $subjectName }}s/{{ $model->id }}/favorites" method="post">
	@csrf
	@if ($model->is_favorited)
		@method('DELETE')
	@endif
</form>
<span class="favorites-count">{{ $model->favorites_count }}</span>
