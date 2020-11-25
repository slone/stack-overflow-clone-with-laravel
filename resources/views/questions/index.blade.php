@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('All Questions') }}</div>

                <div class="card-body">
                    @foreach ($questions as $question)
                    <div class="media">
                        <div class="d-flex flex-column counters">
                            <div class="vote">
                                <strong>{{ $question->votes }}</strong> <span class="label">{{ Str::plural('vote', $question->votes) }}</span>
                            </div>
                            <div class="status {{ $question->status_text }}">
                                <strong>{{ $question->answers }}</strong> <span class="label">{{ Str::plural('answer', $question->answers) }}</span>
                            </div>
                            <div class="view">
                                {{ $question->views .' '. Str::plural('view', $question->views) }}
                            </div>
                        </div>
                        <div class="media-body">
                            <h3 class="mt-0"><a href="{{ $question->url }}">{{ $question->title }}</a></h3>
                            <p class="lead">
                                Asked by <a href="{{$question->user->url}}">{{ $question->user->name }}</a>
                                <small class="text-muted">{{ $question->created_date }}</small>
                            </p>
                            {{ Str::limit($question->body, 250) }}</p>
                        </div>
                    </div>
                    <hr>
                    @endforeach

                    {{ $questions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
