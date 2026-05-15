<!--
Integrantes da dupla:
Nome: Luciano de Sousa Lopes
RA: 2760482522026

Nome: Alice Thyssen
-->


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Chamados</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="fw-bold text-primary">
            Sistema de Chamados
        </h1>

        <a href="create.html" class="btn btn-success">
            Novo Chamado
        </a>

    </div>

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form method="GET" class="row g-3">

                <!-- Filter by status -->
                <div class="col-md-4">

                    <label for="status" class="form-label fw-semibold">
                        Filtrar por Status
                    </label>

                    <select name="status" id="status" class="form-select">

                        <option value="">
                            Todos
                        </option>

                        <option value="aberto"
                            <?= isset($_GET['status']) && $_GET['status'] == 'aberto' ? 'selected' : '' ?>>
                            Aberto
                        </option>

                        <option value="andamento"
                            <?= isset($_GET['status']) && $_GET['status'] == 'andamento' ? 'selected' : '' ?>>
                            Andamento
                        </option>

                        <option value="fechado"
                            <?= isset($_GET['status']) && $_GET['status'] == 'fechado' ? 'selected' : '' ?>>
                            Fechado
                        </option>

                    </select>

                </div>

                <!-- Order by date -->
                <div class="col-md-4">

                    <label for="order" class="form-label fw-semibold">
                        Ordenar por Data
                    </label>

                    <select name="order" id="order" class="form-select">

                        <option value="DESC"
                            <?= isset($_GET['order']) && $_GET['order'] == 'DESC' ? 'selected' : '' ?>>
                            Mais recentes
                        </option>

                        <option value="ASC"
                            <?= isset($_GET['order']) && $_GET['order'] == 'ASC' ? 'selected' : '' ?>>
                            Mais antigos
                        </option>

                    </select>

                </div>

                <div class="col-md-4 d-flex align-items-end gap-2">

                    <button type="submit" class="btn btn-primary">
                        Aplicar
                    </button>

                    <a href="index.php" class="btn btn-secondary">
                        Limpar
                    </a>

                </div>

            </form>

        </div>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <?php

            include 'conect.php';

            // Base query
            $sql = "SELECT * FROM chamados";

            // Filter by status
            if (isset($_GET['status']) && $_GET['status'] != '') {

                $status = $_GET['status'];

                $sql .= " WHERE status = '$status'";
            }

            // Order by date
            $order = "DESC";

            if (isset($_GET['order']) && $_GET['order'] == 'ASC') {
                $order = "ASC";
            }

            $sql .= " ORDER BY data_criacao $order";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {

                echo "
                <div class='table-responsive'>

                    <table class='table table-hover align-middle'>

                        <thead class='table-dark'>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Prioridade</th>
                                <th>Status</th>
                                <th class='text-center'>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                ";

                while ($row = $result->fetch_assoc()) {

                    // Badge colors
                    $priorityClass = match($row['prioridade']) {
                        'alta' => 'danger',
                        'media' => 'warning',
                        default => 'success'
                    };

                    $statusClass = match($row['status']) {
                        'fechado' => 'secondary',
                        'andamento' => 'primary',
                        default => 'success'
                    };

                    echo "
                        <tr>

                            <td>{$row['id']}</td>

                            <td class='fw-semibold'>
                                {$row['titulo']}
                            </td>

                            <td>
                                <span class='badge bg-{$priorityClass}'>
                                    {$row['prioridade']}
                                </span>
                            </td>

                            <td>
                                <span class='badge bg-{$statusClass}'>
                                    {$row['status']}
                                </span>
                            </td>

                            <td class='text-center'>

                                <a 
                                    href='edit.php?id={$row['id']}'
                                    class='btn btn-sm btn-primary me-2'
                                    title='Editar chamado'
                                >
                                    Editar
                                </a>

                                <a 
                                    href='delete.php?id={$row['id']}'
                                    class='btn btn-sm btn-danger'
                                    title='Excluir chamado'
                                >
                                    Excluir
                                </a>

                            </td>

                        </tr>
                    ";
                }

                echo "
                        </tbody>
                    </table>

                </div>
                ";

            } else {

                echo "
                    <div class='alert alert-info mb-0'>
                        Não há chamados cadastrados.
                    </div>
                ";
            }

            $conn->close();

            ?>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>