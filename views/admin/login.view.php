<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumia - Painel Administrativo</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="assets/css/admin.css" rel="stylesheet">
    <link href="assets/css/login.css" rel="stylesheet">
</head>

<body>

    <div class="login-wrap">
        <div class="login-brand">
            <div class="logo-icon">LM</div>
            <div class="logo-text">Lumia <span>Panel</span></div>
        </div>

        <div class="card login-card">

            <!-- Caixa de alertas -->
            <div class="login-alert error<?php if (!empty($loginError)) echo ' show'; ?>" id="loginAlert">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="12" cy="12" r="9" />
                    <line x1="12" y1="8" x2="12" y2="13" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                <span id="loginAlertText">Usuário ou senha incorretos. Tente novamente.</span>
            </div>

            <h1 class="login-title">Acessar Painel</h1>
            <p class="login-subtitle">Entre com suas credenciais para continuar</p>

            <form method="POST" action="index.php?<?php echo http_build_query(['route' => 'admin/login']); ?>" class="login-form" id="loginForm">
                <input type="hidden" name="_csrf" value="<?php echo e(csrf_token()); ?>" />
                <div class="form-group">
                    <label class="form-label">Usuário</label>
                    <input class="form-input" type="text" id="username" name="username" value="<?php echo e($oldUsername ?? ''); ?>" placeholder="Digite seu usuário" autocomplete="username" required>
                </div>

                <div class="form-group login-field">
                    <label class="form-label">Senha</label>
                    <input class="form-input" type="password" id="password" name="password" placeholder="Digite sua senha" autocomplete="current-password" required>
                    <button type="button" class="login-toggle-pass" id="togglePass" aria-label="Mostrar senha">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>

                <div class="login-options">
                    <label class="login-remember">
                        <input type="checkbox" id="remember" name="remember">
                        Lembrar-me
                    </label>
                    <a href="#">Esqueci minha senha</a>
                </div>

                <button type="submit" class="btn btn-primary" id="login-btn">Entrar</button>
            </form>
            <p class="login-footer">&copy; 2026 Lumia. Todos os direitos reservados.</p>
        </div>
    </div>
    <script>
        // Visibilidade da Senha
        document.getElementById('togglePass').addEventListener('click', () => {
            const pass = document.getElementById('password');
            pass.type = pass.type === 'password' ? 'text' : 'password';
        });
    </script>
</body>

</html>