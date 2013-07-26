<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reportgenerator_model
 *
 * @author mince
 */
class reportgenerator_model extends CI_Model {
    
    var $hosts_and_vuln;
    
    public function __construct() {
        parent::__construct();
        
    }
    
    public function report_by_host($report_id)
    {
        //$query = $this->db->query("select Hosts.HostID,Hosts.Name,HostsVulnerabilities.VulnID from Hosts INNER JOIN HostsVulnerabilities on Hosts.HostID = HostsVulnerabilities.HostID Where Hosts.ReportID = ".  intval($report_id));
        $query = $this->db->query("SELECT HostID,Name FROM Hosts WHERE ReportID = ".  intval($report_id));
        $hosts = $query->result();
        //SELECT * FROM `HostsVulnerabilities` INNER JOIN Vulnerabilities on HostsVulnerabilities.VulnID = Vulnerabilities.VulnID ORDER BY Vulnerabilities.Severity DESC;
        foreach ($hosts as $host)
        {
            $query = $this->db->query("SELECT * FROM `HostsVulnerabilities` INNER JOIN Vulnerabilities on HostsVulnerabilities.VulnID = Vulnerabilities.VulnID WHERE HostsVulnerabilities.HostID = ".  intval($host->HostID)." AND Vulnerabilities.Severity > 0 ORDER BY Vulnerabilities.Severity DESC;");
            $host->VulnID = $query->result();
        }
        return $hosts;
    }
    
    public function full_report_by_host($report_id)
    {
        //$query = $this->db->query("select Hosts.HostID,Hosts.Name,HostsVulnerabilities.VulnID from Hosts INNER JOIN HostsVulnerabilities on Hosts.HostID = HostsVulnerabilities.HostID Where Hosts.ReportID = ".  intval($report_id));
        $query = $this->db->query("SELECT HostID,Name FROM Hosts WHERE ReportID = ".  intval($report_id));
        $hosts = $query->result();
        //SELECT * FROM `HostsVulnerabilities` INNER JOIN Vulnerabilities on HostsVulnerabilities.VulnID = Vulnerabilities.VulnID ORDER BY Vulnerabilities.Severity DESC;
        foreach ($hosts as $host)
        {
            $query = $this->db->query("SELECT * FROM `HostsVulnerabilities` INNER JOIN Vulnerabilities on HostsVulnerabilities.VulnID = Vulnerabilities.VulnID WHERE HostsVulnerabilities.HostID = ".  intval($host->HostID)." ORDER BY Vulnerabilities.Severity DESC;");
            $host->VulnID = $query->result();
        }
        return $hosts;
    }
    
    public function report_by_vuln($report_id)
    {
        if($this->db->where("ReportID", $report_id)->get("Reports")->num_rows() != 1)
            redirect ("login");
        $vuln_list = $this->db->query
                ("SELECT 
                DISTINCT `Vulnerabilities`.`VulnID` , 
                `Vulnerabilities`.`Port`,
                `Vulnerabilities`.`Service`,
                `Vulnerabilities`.`Protocol`,
                `Vulnerabilities`.`Name`,
                `Vulnerabilities`.`RiskFactor`,
                `Vulnerabilities`.`Severity`,
                `Vulnerabilities`.`Synopsis`,
                `Vulnerabilities`.`Description`,
                `Vulnerabilities`.`PluginID`,
                `Vulnerabilities`.`Family`,
                `Vulnerabilities`.`VulnPublicationDate`,
                `Vulnerabilities`.`ExploitabilityEase`,
                `Vulnerabilities`.`Solution`,
                `Vulnerabilities`.`PluginPublicationDate`,
                `Vulnerabilities`.`PluginModificationDate`,
                `Vulnerabilities`.`PatchPublicationDate`,
                `Vulnerabilities`.`SeeAlso`,
                `Vulnerabilities`.`CvssBaseScore`,
                `Vulnerabilities`.`Cve`,
                `Vulnerabilities`.`Bid`,  
                `Vulnerabilities`.`Xref`,
                `Vulnerabilities`.`ExploitAvailable`
                FROM `Hosts` 
                INNER JOIN 
                `HostsVulnerabilities` on `HostsVulnerabilities`.`HostID` = `Hosts`.`HostID` 
                INNER JOIN 
                `Vulnerabilities` on `Vulnerabilities`.`VulnID` = `HostsVulnerabilities`.`VulnID` 
                WHERE `Hosts` .`ReportID` = ".intval($report_id)." AND `Vulnerabilities`.`Severity` > 0 ORDER BY `Vulnerabilities`.`Severity` DESC 
           ")->result();
        foreach ($vuln_list as $vuln)
        {
            $vuln->HostList = $this->db->query("SELECT `Hosts`.`Name` FROM `Hosts` INNER JOIN `HostsVulnerabilities` on `HostsVulnerabilities`.`HostID` = `Hosts`.`HostID` WHERE `Hosts`.`ReportID` = ".intval($report_id)." AND `HostsVulnerabilities`.`VulnID` = ".intval($vuln->VulnID))->result();
        }
        return $vuln_list;
    }
public function full_report_by_vuln($report_id)
    {
        if($this->db->where("ReportID", $report_id)->get("Reports")->num_rows() != 1)
            redirect ("login");
        $vuln_list = $this->db->query
            ("SELECT 
            DISTINCT `Vulnerabilities`.`VulnID` , 
            `Vulnerabilities`.`Port`,
            `Vulnerabilities`.`Service`,
            `Vulnerabilities`.`Protocol`,
            `Vulnerabilities`.`Name`,
            `Vulnerabilities`.`RiskFactor`,
            `Vulnerabilities`.`Severity`,
            `Vulnerabilities`.`Synopsis`,
            `Vulnerabilities`.`Description`,
            `Vulnerabilities`.`PluginID`,
            `Vulnerabilities`.`Family`,
            `Vulnerabilities`.`VulnPublicationDate`,
            `Vulnerabilities`.`ExploitabilityEase`,
            `Vulnerabilities`.`Solution`,
            `Vulnerabilities`.`PluginPublicationDate`,
            `Vulnerabilities`.`PluginModificationDate`,
            `Vulnerabilities`.`PatchPublicationDate`,
            `Vulnerabilities`.`SeeAlso`,
            `Vulnerabilities`.`CvssBaseScore`,
            `Vulnerabilities`.`Cve`,
            `Vulnerabilities`.`Bid`,  
            `Vulnerabilities`.`Xref`,
            `Vulnerabilities`.`ExploitAvailable`
            FROM `Hosts` 
            INNER JOIN 
            `HostsVulnerabilities` on `HostsVulnerabilities`.`HostID` = `Hosts`.`HostID` 
            INNER JOIN 
            `Vulnerabilities` on `Vulnerabilities`.`VulnID` = `HostsVulnerabilities`.`VulnID` 
            WHERE `Hosts` .`ReportID` = ".intval($report_id)." ORDER BY `Vulnerabilities`.`Severity` DESC 
           ")->result();
        foreach ($vuln_list as $vuln)
        {
            $vuln->HostList = $this->db->query("SELECT `Hosts`.`Name` FROM `Hosts` INNER JOIN `HostsVulnerabilities` on `HostsVulnerabilities`.`HostID` = `Hosts`.`HostID` WHERE `Hosts`.`ReportID` = 1 and `HostsVulnerabilities`.`VulnID` = ".intval($vuln->VulnID))->result();
        }
        return $vuln_list;
    }
    /**
     *  IT'S TIME TO CHARTING TIME!
     * @param type $report_id
     * @return type
     */
    public function chart_top10_vuln_rate($report_id)
    {
        if($this->db->where("ReportID", $report_id)->get("Reports")->num_rows() != 1)
            redirect ("login");        
        return $this->db->query("
                                SELECT                                                                     
                                `Vulnerabilities`.`Name` as VulnName,
                                COUNT(*) Count
                                FROM `Hosts` 
                                INNER JOIN `HostsVulnerabilities` 
                                on `HostsVulnerabilities`.`HostID` = `Hosts`.`HostID` 
                                INNER JOIN `Vulnerabilities` 
                                on `Vulnerabilities`.`VulnID` = `HostsVulnerabilities`.`VulnID`
                                WHERE `Hosts`.`ReportID` = ".$report_id." and `Vulnerabilities`.`Severity` > 1  
                                GROUP BY `Vulnerabilities`.`Name` 
                                ORDER BY `Vulnerabilities`.`Severity` 
                                LIMIT 0,10")->result();


    }
    public function chart_host_vuln($report_id)
    {
        if($this->db->where("ReportID", $report_id)->get("Reports")->num_rows() != 1)
                redirect ("login");
        return $this->db->query("
                    SELECT * FROM (
                    SELECT
                    Hosts.Name,
                    COUNT(*) as Count
                    FROM
                    Hosts
                    INNER JOIN HostsVulnerabilities
                    on HostsVulnerabilities.HostID = Hosts.HostID
                    INNER JOIN Vulnerabilities
                    on HostsVulnerabilities.VulnID = Vulnerabilities.VulnID
                    WHERE Hosts.ReportID = ".$report_id." and Vulnerabilities.Severity > 1
                    GROUP BY Hosts.Name
                    ) as x WHERE x.Count > 0 
                    LIMIT 0,30
                    
                    ")->result();
    }
    /**
     * biliyorum insan değilim :)
     * @param type $report_id
     * @return type
     */
    public function chart_host_vuln_detail($report_id)
    {
        if($this->db->where("ReportID", $report_id)->get("Reports")->num_rows() != 1)
                redirect ("login");
        return $this->db->query("
            SELECT * FROM (
                SELECT 
                `Hosts`.`Name`,
                CASE WHEN `C`.`Critical` IS NULL THEN	0 ELSE  `C`.`Critical` END as Critical,
                CASE WHEN `H`.`High` IS NULL THEN 0 ELSE `H`.`High` END as High,
                CASE WHEn `M`.`Medium` IS NULL THEN 0 ELSE `M`.`Medium` END as Medium
                FROM 
                `Hosts`
                LEFT JOIN
                (
                        SELECT
                        `Hosts`.`Name`,
                        COUNT(*) as Medium
                        FROM
                        `Hosts`
                        INNER JOIN `HostsVulnerabilities`
                        on
                        `HostsVulnerabilities`.`HostID` = `Hosts`.`HostID`
                        INNER JOIN 
                        `Vulnerabilities`
                        on
                        `HostsVulnerabilities`.`VulnID` = `Vulnerabilities`.`VulnID`
                        WHERE `Vulnerabilities`.`Severity` = 2
                        GROUP BY `Hosts`.`Name`
                ) as M on `M`.`Name` = `Hosts`.`Name` 
                LEFT JOIN
                (
                        SELECT
                        `Hosts`.`Name`,
                        COUNT(*) as High
                        FROM
                        `Hosts`
                        INNER JOIN `HostsVulnerabilities`
                        on
                        `HostsVulnerabilities`.`HostID` = `Hosts`.`HostID`
                        INNER JOIN 
                        `Vulnerabilities`
                        on
                        `HostsVulnerabilities`.`VulnID` = `Vulnerabilities`.`VulnID`
                        WHERE `Vulnerabilities`.`Severity` = 3
                        GROUP BY `Hosts`.`Name`
                        ) as H on `H`.`Name` = `Hosts`.`Name`
                        LEFT JOIN
                (
                        SELECT
                        `Hosts`.`Name`,
                        COUNT(*) as Critical
                        FROM
                        `Hosts`
                        INNER JOIN `HostsVulnerabilities`
                        on
                        `HostsVulnerabilities`.`HostID` = `Hosts`.`HostID`
                        INNER JOIN 
                        `Vulnerabilities`
                        on
                        `HostsVulnerabilities`.`VulnID` = `Vulnerabilities`.`VulnID`
                        WHERE `Vulnerabilities`.`Severity` = 4
                        GROUP BY `Hosts`.`Name`
                ) as C on `C`.`Name` = `Hosts`.`Name`
                WHERE 
                Hosts.ReportID = ".  intval($report_id) ." ORDER BY `C`.`Critical` DESC) as x WHERE x.Medium > 0 or x.High > 0 or x.Critical > 0 LIMIT 0,30")->result();
    }
    ############################ EXPLOITABLE ###############################
    public function exloitable_report_by_vuln($report_id)
    {
        if($this->db->where("ReportID", $report_id)->get("Reports")->num_rows() != 1)
            redirect ("login");
        $vuln_list = $this->db->query
                ("SELECT 
                DISTINCT `Vulnerabilities`.`VulnID` , 
                `Vulnerabilities`.`Port`,
                `Vulnerabilities`.`Service`,
                `Vulnerabilities`.`Protocol`,
                `Vulnerabilities`.`Name`,
                `Vulnerabilities`.`RiskFactor`,
                `Vulnerabilities`.`Severity`,
                `Vulnerabilities`.`Synopsis`,
                `Vulnerabilities`.`Description`,
                `Vulnerabilities`.`PluginID`,
                `Vulnerabilities`.`Family`,
                `Vulnerabilities`.`VulnPublicationDate`,
                `Vulnerabilities`.`ExploitabilityEase`,
                `Vulnerabilities`.`Solution`,
                `Vulnerabilities`.`PluginPublicationDate`,
                `Vulnerabilities`.`PluginModificationDate`,
                `Vulnerabilities`.`PatchPublicationDate`,
                `Vulnerabilities`.`SeeAlso`,
                `Vulnerabilities`.`CvssBaseScore`,
                `Vulnerabilities`.`Cve`,
                `Vulnerabilities`.`Bid`,  
                `Vulnerabilities`.`Xref`,
                `Vulnerabilities`.`ExploitAvailable`,
                `Vulnerabilities`.`ExploitFrameworkCanvas`,
                `Vulnerabilities`.`ExploitFrameworkCore`,
                `Vulnerabilities`.`ExploitFrameworkMetasploit`,
                `Vulnerabilities`.`MetasploitName`
                FROM `Hosts` 
                INNER JOIN 
                `HostsVulnerabilities` on `HostsVulnerabilities`.`HostID` = `Hosts`.`HostID` 
                INNER JOIN 
                `Vulnerabilities` on `Vulnerabilities`.`VulnID` = `HostsVulnerabilities`.`VulnID` 
                WHERE `Hosts` .`ReportID` = ".intval($report_id)." AND `Vulnerabilities`.`Severity` > 0 
                
                ORDER BY `Vulnerabilities`.`Severity` DESC 
                ")->result();
        foreach ($vuln_list as $vuln)
        {
            $vuln->HostList = $this->db->query("SELECT `Hosts`.`Name` FROM `Hosts` INNER JOIN `HostsVulnerabilities` on `HostsVulnerabilities`.`HostID` = `Hosts`.`HostID` WHERE `Hosts`.`ReportID` = ".intval($report_id)." AND `HostsVulnerabilities`.`VulnID` = ".intval($vuln->VulnID))->result();
        }
        return $vuln_list;
    }    
}

?>
