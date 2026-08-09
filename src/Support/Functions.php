<?php


// Proteção de ataque XSS
function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// Validação da Foto
function validatePhoto(array $file): array
{
    // Verifica se o campo realmente foi enviado
    if (!isset($file['error']) || is_array($file['error'])) {
        return ['success' => false, 'error' => 'Upload inválido.'];
    }

    // Verifica erros do próprio PHP
    switch ($file['error']) {
        case UPLOAD_ERR_OK;
        break;
        case UPLOAD_ERR_NO_FILE;
            return['success' => false, 'error' => 'Nenhum arquivo enviado.'];
        case UPLOAD_ERR_INI_SIZE;
        case UPLOAD_ERR_FORM_SIZE;
            return['success' => false, 'error' => 'Arquivo excedo o tamanho permitido pelo servidor.'];
        default:
        return['success' => false, 'error' => 'Erro desonhecido no upload.'];
    }

    // Limite de 5MB
    $maxSize = 5 * 1024 * 1024;
    if ($file['size'] > $maxSize) {
        return['success' => false, 'error' => 'O arquivo deve ter no máximo 5MB.'];
    }

    // Valida a extensão
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, $allowedExtensions)) {
        return['success' => false, 'error' => 'Extensão inválida. Permitido: JPG, JPEG e PNG.'];
    }

    // Valida o tipo MIME real do arquivo
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);

    $allowedMimeTypes = ['image/jpeg', 'image/png'];
    if (!in_array($mimeType, $allowedMimeTypes)) {
        return['success' => false, 'error' => 'O arquivo não é uma imagem válida.'];
    }

    return ['success' => true, 'error' => null];
}

// Upload da Foto
function uploadPhoto(array $file, string $uploadDir): array
{
    // Garente que a pasta existe
    if(!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Gera um nome único, mantendo a extensão original
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = uniqid('product_') . '.' . $extension;
    $destination = rtrim($uploadDir, '/') . '/' . $filename;

    if(!move_uploaded_file($file['tmp_name'], $destination)) {
        return ['success' => false, 'filename' => null, 'error' => 'Falha ao salvar a imagem no servidor.'];
    }

    return ['success' => true, 'filename' => $filename, 'error' => null];
}
