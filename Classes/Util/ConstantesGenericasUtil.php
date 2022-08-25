<?php

namespace Util;

abstract class ConstantesGenericasUtil
{
    /* REQUESTS */
    public const TIPO_REQUEST = ['GET', 'POST', 'DELETE', 'PUT'];
    public const TIPO_ROTA = ['USUARIOS'];

    /* ERROS */
    public const MSG_ERRO_TIPO_ROTA = 'Rota não permitida!';
    public const MSG_ERRO_RECURSO_INEXISTENTE = 'Recurso inexistente!';
    public const MSG_ERRO_GENERICO = 'Algum erro ocorreu na requisição!';
    public const MSG_ERRO_SEM_RETORNO = 'Nenhum registro encontrado!';
    public const MSG_ERRO_NAO_AFETADO = 'Nenhum registro afetado!';
    public const MSG_ERRO_TOKEN_VAZIO = 'É necessário informar um Token!';
    public const MSG_ERRO_TOKEN_NAO_AUTORIZADO = 'Token não autorizado!';
    public const MSG_ERR0_JSON_VAZIO = 'O Corpo da requisição não pode ser vazio!';
    public const MSG_ERR0_IMAGE = 'Erro de Importação de Imagem';
    public const MSG_ERR0_DOCUMENT = 'Erro de Importação de Documento';
    public const MSG_ERR0_IMAGE_TIPO = 'Tipo de Imagem Inexistente';
    public const MSG_ERR0_DOCUMENT_TIPO = 'Tipo de Documento Inexistente';
    public const MSG_ERRO_INSERT = 'Erro de Inserção na Tabela ';
    public const MSG_ERRO_SELECT = 'Erro de Seleção na Tabela ';
    public const MSG_ERRO_UPDATE = 'Erro de Atualização na Tabela ';
    public const MSG_ERRO_DELETE = 'Erro de Exclução na Tabela ';

    /* SUCESSO */
    public const MSG_INSERIDO_SUCESSO = 'Registro inserido com Sucesso!';
    public const MSG_DELETADO_SUCESSO = 'Registro deletado com Sucesso!';
    public const MSG_ATUALIZADO_SUCESSO = 'Registro atualizado com Sucesso!';

    /* RECURSO USUARIOS */
    public const MSG_ERRO_ID_OBRIGATORIO = 'Sem id para Seleção da Tabela ';
    public const MSG_ERRO_LOGIN_EXISTENTE = 'Login já existente!';
    public const MSG_ERRO_LOGIN_SENHA_OBRIGATORIO = 'Login e Senha são obrigatórios!';

    /* RETORNO JSON */
    const TIPO_SUCESSO = 'success';
    const TIPO_ERRO = 'error';

    /* OUTRAS */
    public const SIM = 'S';
    public const STATUS = 'status';
    public const DATA = 'data';
    public const RESPONSE = 'response';
    public const COUNT = 'count';
}