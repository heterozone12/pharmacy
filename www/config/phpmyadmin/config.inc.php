<?php
/**
 * phpMyAdmin configuration for GitHub Codespaces
 * Integrated into main Apache server at /phpmyadmin path
 */

// Servers configuration
$i = 0;

// Server mysql
$i++;
$cfg['Servers'][$i]['verbose'] = 'MySQL Server';
$cfg['Servers'][$i]['host'] = 'mysql';
$cfg['Servers'][$i]['port'] = '3306';
$cfg['Servers'][$i]['socket'] = '';
$cfg['Servers'][$i]['auth_type'] = 'cookie';
$cfg['Servers'][$i]['user'] = '';
$cfg['Servers'][$i]['password'] = '';
$cfg['Servers'][$i]['AllowNoPassword'] = true;

// phpMyAdmin configuration storage settings
$cfg['Servers'][$i]['pmadb'] = '';
$cfg['Servers'][$i]['controluser'] = '';
$cfg['Servers'][$i]['controlpass'] = '';

// Other settings
$cfg['blowfish_secret'] = 'basic_php_mysql_codespaces_secret_key_123456789';
$cfg['DefaultLang'] = 'en';
$cfg['ServerDefault'] = 1;
$cfg['UploadDir'] = '';
$cfg['SaveDir'] = '';

// Security and UI settings
$cfg['ShowPhpInfo'] = false;
$cfg['ShowChgPassword'] = true;
$cfg['ShowDbStructureCreation'] = true;
$cfg['ShowDbStructureLastUpdate'] = true;
$cfg['ShowDbStructureLastCheck'] = true;

// Allow access from any domain (important for Codespaces)
$cfg['CheckConfigurationPermissions'] = false;
$cfg['TrustedProxies'] = [];

// Handle reverse proxy headers (Codespaces routing)
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
    $_SERVER['HTTPS'] = $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ? 'on' : 'off';
}

if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
    $_SERVER['HTTP_HOST'] = $_SERVER['HTTP_X_FORWARDED_HOST'];
}

// Set the correct PMA_ABSOLUTE_URI for Codespaces - using /phpmyadmin path
$cfg['PmaAbsoluteUri'] = '/phpmyadmin';

// Fix asset paths for integrated setup
$cfg['ThemeDefault'] = 'pmahomme';
$cfg['StylesheetPath'] = './themes/pmahomme/css/theme.css';
