<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reportregisterer_model
 *
 * @author mince
 */
;
class reportregisterer_model extends CI_Model {
    /**
     * Handling errors
     * @var array
     */
    var $error_handler =  array();
    
    /**
     * Holding all nessus content on this variable!
     * @var type 
     */
    var $stdObjicerik;
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function __destruct() {
        unset($this->error_handler);
    }

    public function get_errors()
    {
        return $this->error_handler;
    }
    /**
     * Calculating report hash with full path name!
     * @param string $report_path
     * @return boolean
     */
    public function calcReportCheckSum($report_path)
    {
        if(file_exists($report_path))
            return md5_file($report_path);
        return FALSE;         
    }
    /**
     * Checking report hash for prevent dublicate report on database!
     * @param type $raport_hash
     * @return boolean
     */
    public function checkReportHash($raport_hash)
    {
        $this->db->where("CheckSum", $raport_hash);
        $query = $this->db->get("Reports");
        if($query->num_rows > 0)
            return FALSE;
        return TRUE;
    }
    /**
     * Inserting new report informations to Report table
     * @param type $data
     * @return boolean
     */
    public function insertReport($data)
    {
        if($this->db->insert("Reports",$data))
            return TRUE;
        return FALSE;
    }
    /**
     * Getting report informations by checksum
     * @param string $report_hash
     * @return array
     */
    public function getReportWithHash($report_hash)
    {
        $this->db->where("CheckSum", $report_hash);
        $query = $this->db->get("Reports");
        return $query->result();
    }
    /**
     * Main method for register all vulnerabilities and hosts data.
     * @param string $report_checksum
     * @param string $report_path
     * @return boolean
     */
    public function reportToDatabase($report_checksum, $report_path)
    {        
        if(!file_exists($report_path))
        {
            $this->error_handler['file_not_exist'] = 1;
            return FALSE;
        }
        // Getting hosts and register them all!
        $this->stdObjicerik = simplexml_load_file($report_path);
        $xmlicerik  = json_decode( json_encode($this->stdObjicerik) , 1);
       
        // Get ReportID. we need that for Hosts table.
        $report_id = $this->_getReportID($report_checksum);
        if($report_id == FALSE)
        {
            $this->error_handler['report_doesnt_exists_on_db'] = 1;
            return FALSE;
        }            
        /*
         * And here we are.. lets parse them all :)
         * we are at "ReportHosts" segment.
         */
        // first loop for iteration on Hosts Name -ipv4 or fqdn-
        // !!!!! if ['Report']['ReportHost'] have only 1 domain! there is not neceery $i .. this is a bug!
        for ($i=0; $i < sizeof($xmlicerik['Report']['ReportHost']); $i++) 
        {
            // $host_data array for "Hosts" tables.
            $host_data = array(
                'ReportID'  => (int)$report_id,
                'Name'      => (string)$xmlicerik['Report']['ReportHost'][$i]['@attributes']['name']
            );
            $this->_registerHost($host_data);
            // second loop for iteration on vulnerabilitis on per hosts!
            for ($j=0; $j < sizeof($xmlicerik['Report']['ReportHost'][$i]['ReportItem']) ; $j++) 
            {
                $vuln_data = array(
                    'Port'          => (int)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['port'],
                    'Service'       => (string)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['svc_name'],
                    'Protocol'      => (string)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['protocol'],
                    'Severity'      => (int)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['severity'],
                    'PluginID'      => (int)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['pluginID'],
                    'Name'          => (string)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['pluginName'],
                    'Family'       => (string)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['@attributes']['pluginFamily'],
                    'Description'   => (string)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['description'],
                    'PluginModificationDate' => (string)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['plugin_modification_date'],
                    'PluginPublicationDate'  => (string)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['plugin_publication_date'],
                    'RiskFactor'             => (string)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['risk_factor'],
                    'Solution'               => (string)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['solution'],
                    'Synopsis'               => (string)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['synopsis'],
                    'Cve'                    => implode(" ", (array)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['cve']),
                    'CvssBaseScore'          => (float)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['cvss_base_score'],
                    'Bid'                    => (int)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['bid'],
                    'ExploitAvailable'       => (boolean)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['exploit_available'],
                    //'Osvdb'                  => implode(" ", (array)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['osvdb']),
                    'SeeAlso'                => (string)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['see_also'],
                    
                    'Synopsis'               => (string)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['synopsis'],
                    'VulnPublicationDate'    => (string)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['vuln_publication_date'],
                    'Xref'                   => implode(" ", (array)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['xref']),
                    'PatchPublicationDate'   => (string)@$xmlicerik['Report']['ReportHost'][$i]['ReportItem'][$j]['patch_publication_date']
                    );
                // All vuln. are handle on $vuln_data array. lets record vuln to db
                if(!$this->_registerVuln($vuln_data))
                {
                    $this->error_handler['cant_insert_vulndata_to_db'] = TRUE;
                    return FALSE;
                }
                // Getting vuln. id from db
                $_vuld_id = $this->_getVulnID($vuln_data['PluginID']);
                if( $_vuld_id == FALSE )
                {
                    $this->error_handler['cant_get_vuln_id_from_db'] = $vuln_data['PluginID'];
                    return FALSE;                    
                }
                // getting hosts id from db
                $_host_id = $this->_getHostsID($report_id, $host_data['Name']);
                if( $_host_id == FALSE )
                {
                    $this->error_handler['cant_get_host_id_from_db'] = TRUE;
                    return FALSE;                     
                }
                // lets bind vuln to hosts.
                if(!$this->_bindVulnToHost($_host_id, $_vuld_id))
                {
                    $this->error_handler['cant_bind_vuln_to_host'] = FALSE;
                    return FALSE;
                }
                    
            }
        }
        return TRUE;        
    }
    private function _getReportID($report_checksum)
    {
        $this->db->where("CheckSum", $report_checksum);
        $query = $this->db->get("Reports");
        if($query->num_rows() == 1)
        {
            $result = $query->result();
            return $result[0]->ReportID;            
        }       
        return FALSE;
    }
    private function _registerHost($data)
    {
        if($this->db->insert("Hosts", $data))
                return TRUE;
        return FALSE;
        
    }
    private function _getHostsID($report_id, $host_name)
    {
        $this->db->where("ReportID",$report_id);
        $this->db->where("Name",$host_name);
        $query = $this->db->get("Hosts");
        if($query->num_rows() == 1)
        {
            $result = $query->result();
            return $result[0]->HostID;            
        }       
        return FALSE;        
        
        
    }
    private function _registerVuln($vuln_data)
    {   
        $insert_query = $this->db->insert_string("Vulnerabilities", $vuln_data);
        $insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);         
        if($this->db->query($insert_query))
                return TRUE;
        return FALSE;
    }    
    private function _getVulnID($plugin_id)
    {
        $this->db->where("PluginID", $plugin_id);
        $query = $this->db->get("Vulnerabilities");
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
               return $row->VulnID;
            }          
        }       
        return FALSE;
    }
    private function _bindVulnToHost($host_id , $vuln_id)
    {
        $this->db->where("VulnID", $vuln_id);
        $this->db->where("HostID", $host_id);
        $query = $this->db->get("HostsVulnerabilities");
        if($query->num_rows() > 0)
            return TRUE;
        $_temp = array(
            'HostID'   => $host_id,
            'VulnID'    => $vuln_id
        );
        if($this->db->insert("HostsVulnerabilities",$_temp))
                return TRUE;
        return FALSE;
    }

    
    
    
    
    
    
    
    
}

?>
