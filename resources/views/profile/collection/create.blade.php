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
                    <h1>Add guitar to collection</h1>
                    <a href="{{ route('collection.show', ['user' => $user->id]) }}" class="icon-text icon-full"><span class="glyphicon glyphicon-list"></span>View collection</a>
                    <a href="{{ route('collection.show', ['user' => $user->id]) }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-list"></span></a>
                </div>
            </div>
            <div class="col-container">
                <form method="POST" action="{{ route('collection.store') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="guitar">@lang('input.guitar') *</label>
                                <input type="text" class="form-control" name="guitar-ac" value="" required id="guitar-autocomplete" placeholder="@lang('input.guitar-autocomplete')">
                                <input type="hidden" class="form-control" name="guitar" required id="guitar-id">
                            </div>
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
