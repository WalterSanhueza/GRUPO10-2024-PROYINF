<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$idioma = 'es'; // idioma por defecto

if (isset($_COOKIE['idiomaSeleccionado'])) {
    $idioma = $_COOKIE['idiomaSeleccionado'];
}

function traducir($clave, $idioma) {
    $traducciones = [
        'es' => [
            'crear_usuario' => 'Crear usuario',
            'iniciar_sesion' => 'Iniciar sesión',
            'cerrar_sesion' => 'Cerrar sesión',
            'creacion_usuario' => 'Creación de Usuario',
            'correo_electronico' => 'Correo electrónico:',
            'nombre_usuario' => 'Nombre de usuario:',
            'rut' => 'RUT:',
            'contrasena' => 'Contraseña:',
            'volver_inicio' => 'Volver a inicio',
            'entrar' => 'Entrar',
        ],
        'en' => [
            'crear_usuario' => 'Sign in',
            'iniciar_sesion' => 'Log in',
            'cerrar_sesion' => 'Log out',
            'creacion_usuario' => 'Create User',
            'correo_electronico' => 'Email:',
            'nombre_usuario' => 'Username:',
            'rut' => 'ID Number:',
            'contrasena' => 'Password:',
            'volver_inicio' => 'Back to home',
            'entrar' => 'Enter',
        ],
        'fr' => [
            'crear_usuario' => 'Créer un utilisateur',
            'iniciar_sesion' => 'Se connecter',
            'cerrar_sesion' => 'Se déconnecter',
            'creacion_usuario' => 'Création d\'utilisateur',
            'correo_electronico' => 'E-mail:',
            'nombre_usuario' => 'Nom d\'utilisateur:',
            'rut' => 'Numéro d\'identification:',
            'contrasena' => 'Mot de passe:',
            'volver_inicio' => 'Retour à l\'accueil',
            'entrar' => 'Entrer',
        ],
    ];


    return $traducciones[$idioma][$clave] ?? $clave;
}