@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            @if (Session::has('success-message'))
                <div class="alert alert-success alert-margin">{{ Session::get('success-message') }}</div>
            @endif
            @if (Session::has('info-message'))
                <div class="alert alert-info alert-margin">{{ Session::get('info-message') }}</div>
            @endif
            <div class="row heading">
                <div class="col-md-12">
                    <h1>@lang('input.upload-guitar-images', ['guitar' => $guitar->name, 'brand' => $guitar->guitarBrand->name])</h1>
                    <a href="{{ route('guitar.show', ['guitar' => $guitar]) }}" class="icon-text icon-full"><span class="glyphicon glyphicon-search"></span>@lang('content.view-guitar')</a>
                    <a href="{{ route('guitar.show', ['guitar' => $guitar]) }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-search"></span></a>
                </div>
            </div>
            <div class="col-container">
                <form method="POST" action="{{ route('guitar.image.store', ['guitar' => $guitar]) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->all() ? ' has-error' : '' }}">
                                <label for="experience">@lang('input.upload-images')</label>
                                <input type="file" class="form-control" name="images[]" multiple>
                                @if ($errors->has('images'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('images') }}</strong>
                                    </span>
                                @endif
                                @foreach ($errors->get('images.*') as $message)
                                    <span class="help-block">
                                        <strong>{{ $message[0] }}</strong>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary form-control">@lang('input.save')</button>
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

