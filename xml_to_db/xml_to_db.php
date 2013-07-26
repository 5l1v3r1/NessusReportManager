<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of xml_to_db
 *
 * @author mince
 */
define("BASEPATH", "mehmet");

// Getting db config data from codeigniter

// get just db information.dont need "default" child array.


class xml_to_db {
    var $config_file;
    var $nessus_xml;
    var $error_handler =  array();
    var $report_checksum;
    var $report_full_path;
    var $database;
    var $black_list = array(
        "11154", # Unknown Service Detection
        "19506", # Nessus Scan Information
        "45590", # Common Platform Enumeration
        "56468", # Time of Last System Startup
        "57033" # Microsoft Patch Bulletin Feasibility Check
    );
    
    public function __construct($report_checksum, $report_full_path) 
    {
        $this->config_file = getcwd()."/application/config/database.php";
        
        if(!file_exists($this->config_file))
        {
            $this->error_handler['database.php does not exists'] = 1;
            print_r($this->get_error());
            exit();
        }
        include ($this->config_file);
        
        if(empty($report_checksum) or empty($report_full_path))
        {
            $this->error_handler['checksume_or_path_is_null'] = 1;
            print_r($this->get_error());
            exit();            
        }
        global $db_config;
        $this->report_checksum = $report_checksum;
        $this->report_full_path = $report_full_path;
        // Database connections
        try
        {
             $this->database = new PDO(
                     "mysql:dbname=".$db['default']['database'].";".
                     "host=".$db_config['hostname'],
                     $db['default']['username'],
                     $db['default']['password']
                     );
        }
        catch ( PDOException $e)
        {
            die($e->getMessage());
        }
    }
    public function __destruct() {
        unset($this->black_list);
        unset($this->error_handler);
        unset($this->report_full_path);
        unset($this->report_checksum);
        unset($this->nessus_xml);
        unset($this->database);
    }
    public function get_error()
    {
        return $this->error_handler;
    }

    public function report_to_database()
    {        
        /*
         * And here we are.. lets parse them all :)
         * we are at "ReportHosts" segment.
         */ 
        
        if(!file_exists($this->report_full_path))
        {
            $this->error_handler['file_not_exist'] = 1;
            return FALSE;
        }
        // Getting hosts and register them all!
        $this->nessus_xml  = json_decode(json_encode(simplexml_load_file($this->report_full_path)) , 1);
        $report_id = $this->_get_report_id($this->report_checksum);
        if($report_id == FALSE)
        {
            $this->error_handler['report_doesnt_exists_on_db'] = 1;
            return FALSE;
        }
        /* IMPORTANT! IF NESSUS FILE HAVE ONLY ONE TARGET!
         * we dont need $i iteration
        */
        if(sizeof($this->nessus_xml['Report']['ReportHost']) == 3)
        {
            $Name = (string)$this->nessus_xml['Report']['ReportHost']['@attributes']['name'];
            
            if($this->_register_host($report_id, $Name) == FALSE)
            {
                $this->error_handler['cant_register_host_to_db'] = 1;
                return FALSE;                
            }
            for ($j=0; $j < sizeof($this->nessus_xml['Report']['ReportHost']['ReportItem']) ; $j++) 
            {
                $vuln_data = array(
                        'Port'                      => (int)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['port'],
                        'Service'                   => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['svc_name'],
                        'Protocol'                  => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['protocol'],
                        'Name'                      => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['pluginName'],
                        'RiskFactor'                => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['risk_factor'],
                        'Severity'                  => (int)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['severity'],
                        'Synopsis'                  => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['synopsis'],
                        'Description'               => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['description'],
                        'PluginID'                  => (int)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['pluginID'],                    
                        'Family'                    => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['pluginFamily'],
                        'VulnPublicationDate'       => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['vuln_publication_date'],
                        'ExploitabilityEase'        => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['exploitability_ease'],
                        'ExploitAvailable'          => (@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['exploit_available'] == "true") ? 1 : 0,
                        'Solution'                  => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['solution'],                    
                        'PluginPublicationDate'     => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['plugin_publication_date'],                    
                        'PluginModificationDate'    => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['plugin_modification_date'],
                        'PatchPublicationDate'      => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['patch_publication_date'],
                        'SeeAlso'                   => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['see_also'],                    
                        'CvssBaseScore'             => (float)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['cvss_base_score'],
                        'Cve'                       => implode(" ", (array)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['cve']),
                        'Bid'                       => (int)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['bid'],
                        'Xref'                      => implode(" ", (array)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['xref']),                    
                        'ExploitFrameworkCanvas'    => (@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['exploit_framework_canvas'] == "true") ? 1 : 0,
                        'ExploitFrameworkCore'      => (@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['exploit_framework_core'] == "true") ? 1 : 0 ,
                        'ExploitFrameworkMetasploit'=> (@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['exploit_framework_metasploit'] == "true") ? 1 : 0,                                  
                        'MetasploitName'            => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['metasploit_name'],                    
                         );            
                // All vuln. are handle on $vuln_data array. lets record vuln to db
                if($this->_register_vuln($vuln_data) == FALSE)
                {
                    $this->error_handler['cant_insert_vulndata_to_db'] = 1;
                    return FALSE;
                }
                
                $_vuld_id = $this->_get_vuln_id($vuln_data['PluginID']);
                if( $_vuld_id == FALSE )
                {
                    $this->error_handler['cant_get_vuln_id_from_db'] = $vuln_data['PluginID'];
                    return FALSE;                    
                }
                
                $_host_id = $this->_get_host_id($report_id, $Name);
                if( $_host_id == FALSE )
                {
                    $this->error_handler['cant_get_host_id_from_db'] = TRUE;
                    return FALSE;                     
                }                
                if(!$this->_bind_vuln_to_host($_host_id, $_vuld_id))
                {
                    $this->error_handler['cant_bind_vuln_to_host'] = FALSE;
                    return FALSE;
                }                
            }                                
        } else {
                for ($i = 0; $i < sizeof($this->nessus_xml['Report']['ReportHost']); $i++) 
                    {                        
                        $Name = (string)$this->nessus_xml['Report']['ReportHost'][$i]['@attributes']['name'];

                        if($this->_register_host($report_id, $Name) == FALSE)
                        {
                            $this->error_handler['cant_register_host_to_db'] = 1;
                            return FALSE;                
                        }
                        for ($j=0; $j < sizeof($this->nessus_xml['Report']['ReportHost'][$i]['ReportItem']) ; $j++) 
                        {
                            $vuln_data = array(
                                'Port'                      => (int)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['port'],
                                'Service'                   => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['svc_name'],
                                'Protocol'                  => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['protocol'],
                                'Name'                      => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['pluginName'],
                                'RiskFactor'                => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['risk_factor'],
                                'Severity'                  => (int)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['severity'],
                                'Synopsis'                  => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['synopsis'],
                                'Description'               => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['description'],
                                'PluginID'                  => (int)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['pluginID'],                    
                                'Family'                    => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['pluginFamily'],
                                'VulnPublicationDate'       => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['vuln_publication_date'],
                                'ExploitabilityEase'        => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['exploitability_ease'],
                                'ExploitAvailable'          => (@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['exploit_available'] == "true") ? 1 : 0,
                                'Solution'                  => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['solution'],                    
                                'PluginPublicationDate'     => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['plugin_publication_date'],                    
                                'PluginModificationDate'    => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['plugin_modification_date'],
                                'PatchPublicationDate'      => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['patch_publication_date'],
                                'SeeAlso'                   => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['see_also'],                    
                                'CvssBaseScore'             => (float)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['cvss_base_score'],
                                'Cve'                       => implode(" ", (array)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['cve']),
                                'Bid'                       => implode(" ", (array)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['bid']),
                                'Xref'                      => implode(" ", (array)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['xref']),                    
                                'ExploitFrameworkCanvas'    => (@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['exploit_framework_canvas'] == "true") ? 1 : 0,
                                'ExploitFrameworkCore'      => (@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['exploit_framework_core'] == "true") ? 1 : 0 ,
                                'ExploitFrameworkMetasploit'=> (@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['exploit_framework_metasploit'] == "true") ? 1 : 0,                                  
                                'MetasploitName'            => (string)@$this->nessus_xml['Report']['ReportHost'][$i]['ReportItem'][$j]['metasploit_name'],                    
                                );            
                            // All vuln. are handle on $vuln_data array. lets record vuln to db
                            if($this->_register_vuln($vuln_data) == FALSE)
                            {
                                $this->error_handler['cant_insert_vulndata_to_db'] = 1;
                                return FALSE;
                            }

                            $_vuld_id = $this->_get_vuln_id($vuln_data['PluginID']);
                            if( $_vuld_id == FALSE )
                            {
                                $this->error_handler['cant_get_vuln_id_from_db'] = $vuln_data['PluginID'];
                                return FALSE;                    
                            }

                            $_host_id = $this->_get_host_id($report_id, $Name);
                            if( $_host_id == FALSE )
                            {
                                $this->error_handler['cant_get_host_id_from_db'] = TRUE;
                                return FALSE;                     
                            }

                            if(!$this->_bind_vuln_to_host($_host_id, $_vuld_id))
                            {
                                $this->error_handler['cant_bind_vuln_to_host'] = FALSE;
                                return FALSE;
                            }                
                        }        
                    }                    
                }                                               
        $this->_update_report_status($report_id);
        return TRUE; 
    }
    private function _update_report_status($report_id)
    {
        try{
        $sorgu = $this->database->prepare("UPDATE Reports SET IsProcessed = 1 WHERE ReportID = :report_id");
        $sorgu->execute(array(':report_id' => $report_id));                   
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return FALSE;
        }
        return TRUE;

    }
    private function _get_report_id($report_checksum)
    {
        $sorgu = $this->database->prepare("SELECT ReportID FROM Reports WHERE CheckSum = :check_sum");
        $sorgu->execute(array(':check_sum' => $report_checksum));
        if( $sorgu->rowCount() == 1)
            return $sorgu->fetchColumn();
        return FALSE;                
    }
    private function _get_vuln_id($plugin_id)
    {
        try{
            $sorgu = $this->database->prepare("SELECT VulnID FROM Vulnerabilities WHERE PluginID = :plugin_id ");
            $sorgu->execute(array(':plugin_id' => $plugin_id));                       
        } catch (PDOException $e){
            //echo $e->getMessage();
            return FALSE;
        }
        return $sorgu->fetchColumn();
    }    
    private function _register_host($report_id, $report_name)
    {   
        try{      
            $kontrol = $this->database->prepare("SELECT COUNT(*) FROM Hosts WHERE ReportID = :report_id AND Name = :name");
            $kontrol->execute(array(':report_id' => $report_id,':name' => $report_name));
            if($kontrol->fetchColumn() > 0)
                return TRUE;            
            $sorgu = $this->database->prepare("INSERT INTO Hosts (ReportID,Name) VALUES (:report_id,:name)");
            $sorgu->execute(
               array(
                    ':report_id'   => $report_id,
                    ':name'        => $report_name
               ));
            
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return FALSE;
        }
        return TRUE;
    }

    private function _get_host_id($report_id, $host_name)
    {
        try{        
            $sorgu = $this->database->prepare("SELECT HostID FROM Hosts WHERE ReportID = :report_id AND Name = :host_name");
            $sorgu->execute(
               array(
                    ':report_id'   => $report_id,
                    ':host_name'        => $host_name
               ));            
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return FALSE;
        }         
        return $sorgu->fetchColumn();
    }
    private function _bind_vuln_to_host($host_id , $vuln_id)
    {
        // Mevcut atama daha önce varmı kontrol et!
        try{
            $kontrol = $this->database->prepare("SELECT COUNT(*) FROM HostsVulnerabilities WHERE HostID = :host_id AND VulnID = :vuln_id");
            $kontrol->execute(array(':host_id' => $host_id , ':vuln_id' => $vuln_id));
            if($kontrol->fetchColumn() > 0)
                return TRUE;
            $sorgu = $this->database->prepare("INSERT INTO HostsVulnerabilities (HostID, VulnID) VALUES (:host_id,:vuln_id)");
            $sorgu->execute(array(':host_id' => $host_id , ':vuln_id' => $vuln_id ));            
        } catch (PDOException $e){
            return FALSE;
        }
        return TRUE;
    }    
    private function _register_vuln($data)
    {   
        $sorgu = $this->database->prepare(
            "INSERT IGNORE INTO `Vulnerabilities` 
            (Port,Service,Protocol,Name,RiskFactor,Severity,Synopsis,Description,PluginID,Family,
            VulnPublicationDate,ExploitabilityEase,ExploitAvailable,Solution,PluginPublicationDate,
            PluginModificationDate,PatchPublicationDate,SeeAlso,CvssBaseScore,Cve,Bid,Xref,
            ExploitFrameworkCanvas,ExploitFrameworkCore,ExploitFrameworkMetasploit,MetasploitName)
            VALUES
            (:Port,:Service,:Protocol,:Name,:RiskFactor,:Severity,:Synopsis,:Description,:PluginID,:Family,
            :VulnPublicationDate,:ExploitabilityEase,:ExploitAvailable,:Solution,:PluginPublicationDate,
            :PluginModificationDate,:PatchPublicationDate,:SeeAlso,:CvssBaseScore,
            :Cve,:Bid,:Xref,
            :ExploitFrameworkCanvas,:ExploitFrameworkCore,:ExploitFrameworkMetasploit,:MetasploitName)"
            );
        if($sorgu->execute(
            array(
                ':Port'                     =>  $data['Port'],
                ':Service'                  =>  $data['Service'],
                ':Protocol'                 =>  $data['Protocol'],
                ':Name'                     =>  $data['Name'],
                ':RiskFactor'               =>  $data['RiskFactor'],                
                ':Severity'                 =>  $data['Severity'],  
                ':Synopsis'                 =>  $data['Synopsis'],
                ':Description'              =>  $data['Description'],
                ':PluginID'                 =>  $data['PluginID'],
                ':Family'                   =>  $data['Family'],
                ':VulnPublicationDate'      =>  $data['VulnPublicationDate'],
                ':ExploitabilityEase'       =>  $data['ExploitabilityEase'],
                ':ExploitAvailable'         =>  $data['ExploitAvailable'],
                ':Solution'                 =>  $data['Solution'],
                ':PluginPublicationDate'    =>  $data['PluginPublicationDate'],
                ':PluginModificationDate'   =>  $data['PluginModificationDate'],
                ':PatchPublicationDate'     =>  $data['PatchPublicationDate'],
                ':SeeAlso'                  =>  $data['SeeAlso'],
                ':CvssBaseScore'            =>  $data['CvssBaseScore'],
                ':Cve'                      =>  $data['Cve'],          
                ':Bid'                      =>  $data['Bid'],
                ':Xref'                     =>  $data['Xref'],
                ':ExploitFrameworkCanvas'   =>  $data['ExploitFrameworkCanvas'],
                ':ExploitFrameworkCore'     =>  $data['ExploitFrameworkCore'],
                ':ExploitFrameworkMetasploit'=> $data['ExploitFrameworkMetasploit'],
                ':MetasploitName'            => $data['MetasploitName']
                )))               
        {
            return TRUE;
        }
            print_r($sorgu->errorInfo());
            return FALSE;            
        
    }     
}
//php xml_to_db.php 56c89e73daca47dd8b7a09d6d8eb5803 ../nessus_report_repo/0820f844b46d45ab0ae9184fb6adf5eb.nessus
if (isset($argv[1]) and isset($argv[2]))
{
    $report_hash = $argv[1];
    $report_path = $argv[2];   
    $prettygirl =  new xml_to_db($report_hash,$report_path);
    $prettygirl->report_to_database();
    print_r($prettygirl->get_error());      
} else
{
    die("command line parameters are not TRUE! php xml_to_db.php hash reportpath \n");
}
?>
