<?php
/**
 * Author: Mehmet INCE
 * Date  : 19 September 2012
 * 
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Example output : Linux
 *  @return string Detecting Server Operating System 
 */
function ServerOS()
{
    return php_uname('s');
}
/**
 * Example output : x86_64
 *  @return string Detecting Server Architecture
 */
function ServerArchitecture()
{
    return php_uname('m');
}
/**
 * Example output : mince-BGA
 * @return string Detecting Server Hostname
 */
function ServerHostname()
{
    return php_uname('n');
}
/**
 * Example output : 3.2.0-29-genericmince
 * @return string Detecting Server Version
 */
function ServerVersion()
{
    return php_uname('r');
}
/**
 * @return  Description
 */
function ServerUptime()
{
    $returndata = "";
    $content = explode(" ",file_get_contents("/proc/uptime"));
    $uptime = $content[0];
    $day = floor($uptime/60/60/24);
    $hour = $uptime/60/60%24;
    $min = $uptime/60%60;
    return ($day . " days " . $hour . " hours " . $min . " minutes.");
}
function ServerLoadAverage()
{
    return shell_exec("application/binary/ServerLoadAverage.sh");
    
}
function ServerRamUsage() {
    return shell_exec("application/binary/ServerFreeMemory.sh"); 
}
function ServerCpuUsage()
{
    return shell_exec("application/binary/ServerCpuUsage.sh"); 
    
}
function ServerDiskUsage()
{
    /* get disk space free (in bytes) */
    $df = disk_free_space("/var/www");
    /* and get disk space total (in bytes)  */
    $dt = disk_total_space("/var/www");
    /* now we calculate the disk space used (in bytes) */
    $du = $dt - $df;
    /* percentage of disk used - this will be used to also set the width % of the progress bar */
    $dp = sprintf('%.2f',($du / $dt) * 100);

    /* and we formate the size from bytes to MB, GB, etc. */
    $df = formatSize($df);
    $du = formatSize($du);
    $dt = formatSize($dt);
    return "%".$dp. " Used.";
}



function formatSize( $bytes )
{
        $types = array( 'B', 'KB', 'MB', 'GB', 'TB' );
        for( $i = 0; $bytes >= 1024 && $i < ( count( $types ) -1 ); $bytes /= 1024, $i++ );
                return( round( $bytes, 2 ) . " " . $types[$i] );
}
?>
