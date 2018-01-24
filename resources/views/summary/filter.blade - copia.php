<form class="form-inline pull-right" method="GET" action="/summary">

    <div class="form-group">
        <select name="aggregate" class="form-control input-sm">
            <option value="day">Diario</option>
            <option value="week">Semanal</option>
            <option value="month">Mensual</option>
        </select>
    </div>

    <div class="form-group">
        <input name="name"
               type="text"
               class="form-control input-sm"
               autocomplete="off"
               placeholder="Trabajador...">
    </div>

    <button type="submit" class="btn btn-primary btn-sm">
        <i class="fa fa-sign-out" aria-hidden="true"></i> Filtrar
    </button>

</form>
