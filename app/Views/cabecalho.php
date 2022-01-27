<ul class="nav justify-content-center">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="<?= URL ?>">Página Inicial</a>
  </li>
  <?php if(isset($_SESSION['usuario_nome'])): ?>
    <?= $_SESSION['usuario_nome']; ?>
    <li class="nav-item">
      <a class="nav-link active" aria-current="page" href="<?= URL . '/usuarios/encerrarSessaoUsuario' ?>">Sair</a>
    </li>
  <?php else: ?>
    <li class="nav-item">
    <a class="nav-link" href="<?= URL . '/usuarios/cadastrar' ?>">Cadastro</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="<?= URL . '/usuarios/login' ?>">Login</a>
  </li>
  <?php endif; ?>
</ul>
