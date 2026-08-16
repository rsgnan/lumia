<?php
// Rota antiga mantida por comptatibilidade
header('Location: index.php?' . http_build_query(['route' => 'admin/login']));
exit;