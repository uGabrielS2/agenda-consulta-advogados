<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <nav class="navbar navbar-dark bg-dark shadow text-light">
    <div class="container-fluid">
      <button class="navbar-toggler ms-1" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <span class="navbar-toggler-icon"></span>
      </button>
      <span class="navbar-brand p-0 me-2"><img src="assets/logo.png" alt="Logo" width="55px"></span>
    </div>
  </nav>
  <div class="modal bg-dark ModalSideBar" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content ModalSideBar bg-dark">
        <div class="modal-header">
          <h1 class="modal-title text-light fs-5" id="exampleModalLabel">Sistema de Agendamento</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body ModalItem">
          <a class="m-3" href="index.php">Página inicial</a>
          <hr class="m-2">
          <a class="m-3" href="telaClientes.php">Clientes</a>
          <hr class="m-2">
          <a class="m-3" href="telaAgendamentos.php">Agendamentos</a>
        </div>
        <hr class="m-2">
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
              class="bi bi-door-open-fill" viewBox="0 0 16 16">
              <path
                d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15zM11 2h.5a.5.5 0 0 1 .5.5V15h-1zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1" />
            </svg> Sair da conta
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Tem certeza que deseja sair da conta?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <a type="button" class="btn btn-danger" href="verify/logout.php">Sim, tenho certeza</a>
        </div>
      </div>
    </div>
  </div>
  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <script src="node_modules/parsleyjs/dist/parsley.min.js"></script>
  <script src="node_modules/parsleyjs/dist/i18n/pt-br.js"></script>
  <link rel="stylesheet" href="node_modules/parsleyjs/src/parsley.css">
</body>

</html>
