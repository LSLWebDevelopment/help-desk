<?php
include 'conect.php';

$row = [];

$success = false;
$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "SELECT * FROM chamados WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id'];

    $update_sql = "UPDATE chamados
                    SET titulo = '{$_POST['title']}',
                        descicao = '{$_POST['description']}',
                        prioridade = '{$_POST['priority']}',
                        status = '{$_POST['status']}'
                    WHERE id = '$id'";

    if ($conn->query($update_sql)) {

        $success = true;

        // Reload updated data
        $sql = "SELECT * FROM chamados WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }

        header("refresh:2;url=list.php");

    } else {

        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Chamado</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow border-0">

                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">Editar Chamado</h2>
                </div>

                <div class="card-body">

                    <?php if ($success): ?>

                        <div class="alert alert-success">
                            Chamado alterado com sucesso! Redirecionando...
                        </div>

                    <?php endif; ?>

                    <?php if ($error): ?>

                        <div class="alert alert-danger">
                            Erro ao alterar chamado.
                        </div>

                    <?php endif; ?>

                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

                        <input 
                            type="hidden" 
                            name="id" 
                            value="<?php echo $row['id'] ?? ''; ?>"
                        >

                        <div class="mb-3">

                            <label for="title" class="form-label fw-semibold">
                                Título
                            </label>

                            <input 
                                type="text"
                                class="form-control"
                                name="title"
                                id="title"
                                value="<?php echo $row['titulo'] ?? ''; ?>"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label for="description" class="form-label fw-semibold">
                                Descrição
                            </label>

                            <textarea 
                                class="form-control"
                                name="description"
                                id="description"
                                rows="5"
                                required
                            ><?php echo $row['descicao'] ?? ''; ?></textarea>

                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label for="priority" class="form-label fw-semibold">
                                    Prioridade
                                </label>

                                <select 
                                    class="form-select"
                                    name="priority"
                                    id="priority"
                                >

                                    <option 
                                        value="baixa"
                                        <?php echo (($row['prioridade'] ?? '') == 'baixa') ? 'selected' : '' ?>
                                    >
                                        Baixa
                                    </option>

                                    <option 
                                        value="media"
                                        <?php echo (($row['prioridade'] ?? '') == 'media') ? 'selected' : '' ?>
                                    >
                                        Média
                                    </option>

                                    <option 
                                        value="alta"
                                        <?php echo (($row['prioridade'] ?? '') == 'alta') ? 'selected' : '' ?>
                                    >
                                        Alta
                                    </option>

                                </select>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label for="status" class="form-label fw-semibold">
                                    Status
                                </label>

                                <select 
                                    class="form-select"
                                    name="status"
                                    id="status"
                                >

                                    <option 
                                        value="aberto"
                                        <?php echo (($row['status'] ?? '') == 'aberto') ? 'selected' : '' ?>
                                    >
                                        Aberto
                                    </option>

                                    <option 
                                        value="andamento"
                                        <?php echo (($row['status'] ?? '') == 'andamento') ? 'selected' : '' ?>
                                    >
                                        Andamento
                                    </option>

                                    <option 
                                        value="fechado"
                                        <?php echo (($row['status'] ?? '') == 'fechado') ? 'selected' : '' ?>
                                    >
                                        Fechado
                                    </option>

                                </select>

                            </div>

                        </div>

                        <div class="d-flex gap-2 mt-4">

                            <button type="submit" class="btn btn-primary">
                                Salvar Alterações
                            </button>

                            <a href="index.html" class="btn btn-secondary">
                                Cancelar
                            </a>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>