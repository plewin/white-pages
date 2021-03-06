<?php
# LDAP Functions 

function wp_ldap_connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw) {

    # Connect to LDAP
    $ldap = ldap_connect($ldap_url);
    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

    if ( $ldap_starttls && !ldap_start_tls($ldap) ) {
        error_log("LDAP - Unable to use StartTLS");
        return array(false, "ldaperror");
    }

    # Bind
    if ( isset($ldap_binddn) && isset($ldap_bindpw) ) {
        $bind = ldap_bind($ldap, $ldap_binddn, $ldap_bindpw);
    } else {
        $bind = ldap_bind($ldap);
    }

    $errno = ldap_errno($ldap);

    if ( $errno ) {
        error_log("LDAP - Bind error $errno  (".ldap_error($ldap).")");
        return array(false, "ldaperror");
    }

    return array($ldap, false);
}

?>
