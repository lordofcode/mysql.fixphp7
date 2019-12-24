<?php
/*
Fix to make removed mysql_ functions in PHP 7 redirect to the mysqli variant
*/
$mysqlConnector = null;
$_t_dbServer = null;
$_t_dbUser = null;
$_t_dbPass = null;

function mysql_connect($dbserver, $dbuser, $dbpass) {
    //global $CONFIG;
    //return new mysqli($dbserver, $dbuser, $dbpass, $CONFIG['dbname']);
    global $_t_dbServer;
    global $_t_dbUser;
    global $_t_dbPass;
    $_t_dbServer = $dbserver;
    $_t_dbUser = $dbuser;
    $_t_dbPass = $dbpass;    
    return true;
}
function mysql_select_db($dbname) {
    global $mysqlConnector;
    global $_t_dbServer;
    global $_t_dbUser;
    global $_t_dbPass;    
    $mysqlConnector = new mysqli($_t_dbServer, $_t_dbUser, $_t_dbPass, $dbname);
    $_t_dbServer = null;
    $_t_dbUser = null;
    $_t_dbPass = null;    
    return true; //already done in mysql_connect
}
function mysql_query($query, $link_id) {
    global $mysqlConnector;
    return $mysqlConnector->query($query);
}
function mysql_fetch_assoc($dbassoc) {
    return $dbassoc->fetch_assoc();
}
function mysql_fetch_row($dbassoc) {
    return $dbassoc->fetch_row();
}
function mysql_fetch_array($dbassoc) {
    return $dbassoc->fetch_array();
}
function mysql_fetch_object($dbassoc) {
    return $dbassoc->fetch_object();
}
function mysql_affected_rows($dbassoc) {
    return 0;
}
function mysql_free_result($dbassoc) {
    $dbassoc = null;
}
function mysql_real_escape_string($input) {
    return addslashes($input);
}
function mysql_escape_string($input) {
    return addslashes($input);    
}
function mysql_num_rows($dbassoc) {
    return mysqli_num_rows($dbassoc);
}
function mysql_result ($result, $row, $field = 0 ) {
    return mysqli_result($result, $row, $field );
}
function mysqli_result($res,$row=0,$col=0){ 
    $numrows = mysqli_num_rows($res); 
    if ($numrows && $row <= ($numrows-1) && $row >=0){
        mysqli_data_seek($res,$row);
        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col])){
            return $resrow[$col];
        }
    }
    return false;
}
?>