<?php
// Configurações do servidor LDAP
define("LDAP_SERVER", "ldap://192.168.3.9"); // Endereço do servidor AD
define("LDAP_PORT", 389); // Porta padrão LDAP
define("LDAP_DOMAIN", "sme.com"); // Domínio do Active Directory

/**
 * Função para autenticar usuário via LDAP.
 *
 * @param string $username Nome de usuário (sem domínio)
 * @param string $password Senha do usuário
 * @return bool Retorna true se autenticado, false caso contrário.
 */
function authenticate($username, $password) {
    $ldap_conn = ldap_connect(LDAP_SERVER, LDAP_PORT);
    if (!$ldap_conn) {
        return false;
    }

    // Define opções do LDAP
    ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

    // Formata o usuário como usuario@sme.com
    $ldap_user = $username . "@" . LDAP_DOMAIN;

    // Tenta autenticar
    $bind = @ldap_bind($ldap_conn, $ldap_user, $password);

    ldap_unbind($ldap_conn); // Fecha a conexão
    return $bind;
}
?>
