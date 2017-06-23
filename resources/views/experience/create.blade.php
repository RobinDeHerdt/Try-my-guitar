@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            @if (Session::has('success-message'))
                <div class="alert alert-success">{{ Session::get('success-message') }}</div>
            @endif
            @if (Session::has('info-message'))
                <div class="alert alert-info">{{ Session::get('info-message') }}</div>
            @endif
            <div class="row heading">
                <div class="col-md-12">
                    <h1>Write your experience with "{{ $guitar->name }}"</h1>
                    <a href="{{ route('guitar.show', ['guitar' => $guitar]) }}" class="icon-text icon-full"><span class="glyphicon glyphicon-search"></span>Show guitar</a>
                    <a href="{{ route('guitar.show', ['guitar' => $guitar]) }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-search"></span></a>
                </div>
            </div>
            <div class="col-container">
                <form method="POST" action="{{ route('experience.store', ['guitar' => $guitar]) }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="guitar" value="{{ $guitar->id }}">
                            <div class="form-group">
                                <label for="experience">@lang('input.experience')</label>
                                <textarea name="experience" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary form-control">Save</button>
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

