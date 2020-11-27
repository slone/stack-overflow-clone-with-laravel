@extends('layouts.app')

@section('content')
<div class="row mt-4 justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h1>{{ __('Editing answer for').' '. $question->title }}</h1>
                </div>
                <hr>
                <form action="{{ route('questions.answers.update', [$question->id, $answer->id]) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <textarea class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" rows="7" name="body">{{ old('body', $answer->body) }}</textarea>

                        @if ($errors->has('body'))
                            <div class="invalid-feedback">

                                <strong>{{ $errors->first('body') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-outline-primary">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection