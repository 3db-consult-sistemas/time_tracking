<form class="form-inline pull-right" method="GET" action="/tickets">
    <div class="form-group">
        <select name="status" class="form-control input-sm" onchange="this.form.submit()">
            <option value="open" {{ $status == 'open' ? 'selected' : '' }}>Abiertos</option>
            <option value="close" {{ $status == 'close' ? 'selected' : '' }}>Cerrados</option>
        </select>
    </div>
</form>
