<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Chamado</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-6">

            <div class="card shadow border-0">

                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">Criar Chamado</h2>
                </div>

                <div class="card-body">

<?php

include 'conect.php';

$title = $_POST['title'];
$description = $_POST['description'];
$priority = $_POST['priority'];
$status = $_POST['status'];

$sql = "INSERT INTO chamados (descicao, prioridade, status, titulo)
        VALUES ('$description', '$priority', '$status', '$title')";

if ($conn->query($sql) === TRUE) {

    echo "
        <div class='alert alert-success'>
            <h4 class='alert-heading'>Chamado criado com sucesso!</h4>

            <p class='mb-0'>
                O chamado foi registrado no sistema.
            </p>
        </div>

        <div class='d-flex gap-2 mt-4'>

            <a href='index.php' class='btn btn-primary'>
                Ver Chamados
            </a>

            <a href='create.html' class='btn btn-success'>
                Criar Novo Chamado
            </a>

        </div>
    ";

} else {

    echo "
        <div class='alert alert-danger'>
            <h4 class='alert-heading'>Erro ao criar chamado</h4>

            <p class='mb-0'>
                {$conn->error}
            </p>
        </div>

        <a href='create.html' class='btn btn-secondary mt-3'>
            Voltar
        </a>
    ";
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