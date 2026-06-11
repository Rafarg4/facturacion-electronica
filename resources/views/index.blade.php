<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Imagen</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Subir Imagen</h2>
    
    <form id="uploadForm" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" id="image" accept="image/*">
        <button type="submit">Subir</button>
    </form>

    <div id="preview" style="margin-top: 20px;">
        <h3>Vista previa:</h3>
        <img id="previewImage" src="" style="max-width: 300px; display: none;">
    </div>

    <script>
        $.ajax({
    url: "{{ route('subir_imagen') }}",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
        console.log(response);  // 👀 Verifica la respuesta en la consola
        alert(response.message || 'Imagen subida correctamente');
        $('#previewImage').attr('src', response.path).show();
    },
    error: function (xhr) {
        console.error(xhr.responseText); // 👀 Muestra el error detallado
        alert('Error al subir la imagen: ' + xhr.responseText);
    }
});

    </script>
</body>
</html>
