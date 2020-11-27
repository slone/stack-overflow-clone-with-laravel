<div class="row mt-4 justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2> {{ $answersCount . ' ' . Str::plural('Answer', $answersCount) }} </h2>
                </div>
                <hr>
                @foreach ($answers as $answer) 

                    <div class="media">
                            <div class="d-flex flex-column vote-controls">
                                <a title="this answer is useful" class="vote-up">
                                    <i class="fas fa-caret-up fa-2x"></i>
                                </a>
                                <span class="votes-count">
                                    1224
                                </span>
                                <a title="this answer is not useful" class="vote-down off">
                                    <i class="fas fa-caret-down fa-2x"></i>
                                </a>
                                <a title="Mark as best answer" class="vote-accepted mt-2">
                                    <i class="fas fa-check fa-2x"></i>
                                </a>
                                <span class="favorites-count">
                                    54
                                </span>
                            </div>
                            <div class="media-body">
                            {!! $answer->body_html !!}
                            <div class="float-right">
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
                        
                    </div>
                    <hr>

                @endforeach
            </div>
        </div>
    </div>
</div>
