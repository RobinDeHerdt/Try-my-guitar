@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            @include('partials.messages')
            <div class="row heading">
                <div class="col-md-12">
                    <h1>@lang('content.your-guitar-experience', ['guitar' => $guitar->name, 'brand' => $guitar->guitarBrand->name])</h1>
                    <a href="{{ route('guitar.show', ['guitar' => $guitar]) }}" class="icon-text icon-full"><span class="glyphicon glyphicon-search"></span>@lang('content.view-guitar')</a>
                    <a href="{{ route('guitar.show', ['guitar' => $guitar]) }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-search"></span></a>
                </div>
            </div>
            <div class="dashboard-content dashboard-border-bottom">
                <form method="POST" action="{{ route('experience.store', ['guitar' => $guitar]) }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="guitar" value="{{ $guitar->id }}">
                            <div class="form-group {{ $errors->has('experience') ? ' has-error' : '' }}">
                                <label for="experience">@lang('input.experience')</label>
                                <textarea name="experience" cols="30" rows="5" class="form-control" placeholder="@lang('input.describe-experience')"></textarea>
                                @if ($errors->has('experience'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('experience') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary red form-control">@lang('input.save')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection

@section('scripts')
    <script>
        $( "#guitar-autocomplete" ).autocomplete({
            source: "{{ route('collection.autocomplete') }}",
            minLength: 1,
            autoFocus:true,
            select: function (event, ui) {
                $('#guitar-autocomplete').val(ui.item.value);
                $('#guitar-id').val(ui.item.id);
            }
        });
    </script>
    @include('partials.analytics')
@endsection
