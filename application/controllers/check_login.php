<?php

// A sessão precisa ser iniciada em cada página diferente
@session_start();
// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION ['user_info'] ['usuario']) || $_SESSION ['user_info'] ['ativo'] < 1) {
    // Destrói a sessão por segurança
    session_destroy();
    // Redireciona o visitante de volta pro login
    header('location: login.php');
    exit();
}