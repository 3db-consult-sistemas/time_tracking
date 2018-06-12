<form class="form-inline pull-right" method="GET" action="{{ url('/tickets') }}">

    <input list="userNames"
            name="userName"
            value="{{ $userName ?? '' }}"
            placeholder="Nombre"
            class="form-control input-sm"
            autocomplete="off">

    <datalist id="userNames">
        @foreach ($users as $user)
            <option value="{{ $user->username }}">{{ $user->name }}</option>
        @endforeach
    </datalist>

</form>
