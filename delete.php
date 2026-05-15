<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Chamado</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow border-0">

                <div class="card-header bg-danger text-white">
                    <h2 class="mb-0">Deletar Chamado</h2>
                </div>

                <div class="card-body">

<?php

include 'conect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "SELECT * FROM chamados WHERE id = $id";
    $result = $conn->query($sql);

    echo "
        <div class='alert alert-warning'>
            Tem certeza que deseja excluir o registro abaixo?
        </div>
    ";

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

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

        <form method='POST' action='{$_SERVER['PHP_SELF']}'>

            <div class='table-responsive mb-4'>

                <table class='table table-bordered align-middle'>

                    <thead class='table-dark'>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Prioridade</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
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

                        </tr>
                    </tbody>

                </table>

            </div>

            <div class='mb-4'>

                <label class='form-label fw-semibold'>
                    Confirmar exclusão:
                </label>

                <div class='form-check'>
                    <input 
                        class='form-check-input'
                        type='radio'
                        name='delete'
                        id='yes'
                        value='yes'
                        required
                    >

                    <label class='form-check-label' for='yes'>
                        Sim, excluir chamado
                    </label>
                </div>

                <div class='form-check'>
                    <input 
                        class='form-check-input'
                        type='radio'
                        name='delete'
                        id='no'
                        value='no'
                    >

                    <label class='form-check-label' for='no'>
                        Não, cancelar exclusão
                    </label>
                </div>

            </div>

            <input type='hidden' name='id' value='{$row['id']}'>

            <div class='d-flex gap-2'>

                <button type='submit' class='btn btn-danger'>
                    Confirmar
                </button>

                <a href='list.php' class='btn btn-secondary'>
                    Voltar
                </a>

            </div>

        </form>
        ";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id'];
    $delete = $_POST['delete'];

    if ($delete == 'yes') {

        $delete_sql = "DELETE FROM chamados WHERE id = $id";

        if ($conn->query($delete_sql)) {

            echo "
                <div class='alert alert-success'>
                    Registro deletado com sucesso.
                </div>

                <a href='list.php' class='btn btn-primary'>
                    Voltar para lista
                </a>
            ";

        } else {

            echo "
                <div class='alert alert-danger'>
                    Erro ao deletar registro.
                </div>
            ";
        }

    } else {

        echo "
            <div class='alert alert-info'>
                Exclusão cancelada.
            </div>

            <a href='list.php' class='btn btn-secondary'>
                Voltar
            </a>
        ";
    }
}

$conn->close();

?>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>