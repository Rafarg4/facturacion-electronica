 <!-- Bootstrap 5 CSS -->
<style>
/* Solo el estilo necesario para el switch */
.form-check-input[type=checkbox] {
  width: 2.5em;
  height: 1.5em;
  background-color: #dee2e6;
  border-radius: 3em;
  position: relative;
  appearance: none;
  transition: background-color .15s ease-in-out;
}

.form-check-input[type=checkbox]::before {
  content: "";
  position: absolute;
  width: 1em;
  height: 1em;
  background-color: white;
  border-radius: 50%;
  top: 0.25em;
  left: 0.25em;
  transition: transform 0.15s ease-in-out;
}

.form-check-input[type=checkbox]:checked {
  background-color: #0d6efd;
}

.form-check-input[type=checkbox]:checked::before {
  transform: translateX(1em);
}
</style>
<div class="table-responsive" style="padding:15px;font-size: 12px;">
<table class="table" id="productosTable">
        <thead>
            <tr>
                <th>Código</th>
                <th>N° Ítem</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Cantidad Mínima</th>
                <th>Precio</th>
                <th>Costo</th>
                <th>Rubro</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<script>
$(document).ready(function () {

    if ($.fn.DataTable.isDataTable('#productosTable')) {
        $('#productosTable').DataTable().destroy();
    }

    $('#productosTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('productos.data') }}",
        pageLength: 10,
        columns: [
            { data: 'codigo' },
            { data: 'num_item' },
            { data: 'descripcion' },
            { data: 'cantidad' },
            { data: 'cantidad_minima' },
            { data: 'precio1' },
            { data: 'costo' },
            {
                data: 'rubro_descripcion',
                name: 'rubro_descripcion'
            },
            { data: 'estado_switch', orderable: false, searchable: false },
            { data: 'acciones', orderable: false, searchable: false }
        ]
    });

});
function cambiarEstado(id, activo) {
    const estado = activo ? 'Activo' : 'Inactivo';

    fetch(`/productos/${id}/cambiarEstado`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ estado })
    })
    .then(res => res.json())
    .then(data => {
        console.log(data.message);
    })
    .catch(err => console.error('Error:', err));
}
</script>