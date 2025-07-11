<?php
require_once '../modelo/DAO/ContratacaoDAO.php';

function listarContratacoes() {
    $dao = new ContratacaoDAO();
    return $dao->listarTodosComDetalhes();
}
