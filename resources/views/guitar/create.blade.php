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
                    <h1>@lang('content.add-guitar')</h1>
                </div>
            </div>
            <div class="dashboard-content dashboard-border-bottom">
                @if(Auth::user()->verified)
                <form method="POST" action="{{ route('guitar.store') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name">@lang('input.guitar-name') *</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group {{ $errors->has('images') ? ' has-error' : '' }}">
                                <label for="images">@lang('input.upload-images')</label>
                                <input type="file" class="form-control" name="images[]" multiple>
                                @if ($errors->has('images'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('images') }}</strong>
                                    </span>
                                @endif
                                @foreach ($errors->get('images.*') as $message)
                                    <span>{{ $message[0] }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description">@lang('input.description') *</label>
                                <textarea name="description" cols="30" rows="5" class="form-control" required>{{  old('description') }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="{{ $errors->has('brand') ? ' has-error' : '' }}">
                                <label for="brand">@lang('input.brand') *</label>
                                @if ($errors->has('brand'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('brand') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                @foreach($brands as $brand)
                                    <div class="col-md-2">
                                        <label class="radio-inline"><input type="radio" name="brand" value="{{ $brand->id }}" {{  old('brand') == $brand->id ? 'checked' : ''}}>{{ $brand->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="{{ $errors->has('types') ? ' has-error' : '' }}">
                                <label for="types">@lang('input.categories') *</label>
                                @if ($errors->has('types'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('types') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                @foreach($types as $type)
                                    <div class="col-md-2">
                                        <label class="checkbox-inline"><input type="checkbox" name="types[]" value="{{ $type->id }}" {{ old('types') ? in_array($type->id, old('types')) ? 'checked' : '' : ''}}>{{ $type->{"name_" . LaravelLocalization::getCurrentLocale()} }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary red form-control">@lang('input.save')</button>
                            </div>
                        </div>
                    </div>
                </form>
                @else
                    <span><a href="{{ route('dashboard') . "#verify" }}">@lang('content.verify-contribute')</a></span>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection

@section('scripts')
    @include('partials.analytics')
@endsection
