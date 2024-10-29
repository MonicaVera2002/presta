<?php
include 'config.php';

// Verifica si se realizó una búsqueda
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['search_query'])) {
    $searchQuery = $_POST['search_query'];

    // Llamada a la API para buscar clientes por correo o ID
    $response = makeApiRequest("customers/?filter[email]=$searchQuery|filter[id]=$searchQuery", 'GET');
} else {
    // Si no hay búsqueda, obtener todos los clientes
    $response = makeApiRequest('customers', 'GET');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Clientes</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Lista de Clientes</h2>

        <!-- Botón para crear un nuevo cliente -->
        <a href="customer_create.php" class="btn btn-primary mb-3">Crear Nuevo Cliente</a>

        <!-- Formulario de consulta de clientes -->
        <form method="post" class="form-inline mb-3">
            <div class="form-group">
                <input type="text" class="form-control" name="search_query" placeholder="Buscar por ID o correo" required>
            </div>
            <button type="submit" class="btn btn-secondary ml-2">Consultar</button>
        </form>

        <!-- Tabla de clientes -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($response['customers'])): ?>
                    <?php foreach ($response['customers'] as $customer): ?>
                        <tr>
                            <td><?= $customer['id'] ?></td>
                            <td><?= $customer['firstname'] . ' ' . $customer['lastname'] ?></td>
                            <td><?= $customer['email'] ?></td>
                            <td>
                                <a href="customer_view.php?id=<?= $customer['id'] ?>" class="btn btn-info btn-sm">Ver</a>
                                <a href="customer_edit.php?id=<?= $customer['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="customer_delete.php?id=<?= $customer['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No se encontraron clientes.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
