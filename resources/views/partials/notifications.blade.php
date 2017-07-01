@if (Session::has('level-message'))
    <div class="level-window" id="level-window">
        <span>{{ Session::get('level-message') }}</span>
    </div>
@endif
@if (Session::has('exp-message'))
    <div class="exp-window" id="exp-window">
        <span>{{ Session::get('exp-message') }}</span>
    </div>
@endif