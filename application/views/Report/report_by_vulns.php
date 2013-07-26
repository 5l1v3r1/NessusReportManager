<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$_temp_chart_host_vuln_Name = "";
$_temp_chart_host_vuln_Count = "";
foreach ($chart_host_vuln as $value) {
    $_temp_chart_host_vuln_Name .= "'".$value->Name."',";
    $_temp_chart_host_vuln_Count .= $value->Count." , ";
}
#######
$_temp_chart_host_vuln_detail_Name = "";
$_temp_chart_host_vuln_detail_Count_Critical = "";
$_temp_chart_host_vuln_detail_Count_High = "";
$_temp_chart_host_vuln_detail_Count_Medium = "";
foreach ($chart_host_vuln_detail as $row)
{
    $_temp_chart_host_vuln_detail_Name .= "'".$row->Name."',";
    $_temp_chart_host_vuln_detail_Count_Critical .= $row->Critical." , ";
    $_temp_chart_host_vuln_detail_Count_High .= $row->High." , ";
    $_temp_chart_host_vuln_detail_Count_Medium .= $row->Medium." , ";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?=$report_info->ReportName?></title>
    <LINK REL=StyleSheet HREF="<? echo base_url()."css/wnessus.css";?>">
    <LINK REL=StyleSheet HREF="<? echo base_url()."css/bootstrap.css";?>">
    <script type="text/javascript" src="<? echo base_url()."js/bootstrap.js";?>"></script>
    <script type="text/javascript" src="<? echo base_url()."js/jquery1-8-1.min.js";?>"></script>
    <script type="text/javascript" src="<? echo base_url()."js/googlechart.js";?>"></script>
    <script type="text/javascript" src="<? echo base_url()."js/highcharts.js";?>"></script>
    <script type="text/javascript" src="<? echo base_url()."js/highstock.js";?>"></script>
    <script type="text/javascript" src="<? echo base_url()."js/adapters/prototype-adapter.js";?>"></script>
    <style type="text/css">
      body {
      	padding-top: 0px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
      .kaydir {
        padding-left: 40px;
      }
    </style>    
    <script  type="text/javascript">
        var chart; // globally available
        jQuery(function() {

            chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'top10_vuln_rate',
                    backgroundColor:'rgba(255, 255, 255, 0.1)',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                title: {
                    text: 'Top #10 Vulnerability Rate'
                },
                subtitle: {
                    text: 'including Critical,High,Medium',
                    x: -6
                },                
                tooltip: {
                  pointFormat: '{series.name}: <b>{point.percentage}%</b>',
                  percentageDecimals: 1
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            color: '#000000',
                            connectorColor: '#000000',
                            formatter: function() {
                                return '<b>'+ this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 1) +' %';
                            }
                        }
                    }
                },            
                series: [{
                    type: 'pie',
                    name: 'Browser share',
                    data: [                                      
                    <?php
                    foreach ($chart_top10_vuln_rate as $row)
                    {        
                        echo "\t['".html_escape($row->VulnName)."', ".$row->Count."],\n";

                    }?>                                            
                    ]
                }]
            });
        });
    </script>
    <script type="text/javascript">       
        (function($){ // encapsulate jQuery
            var chart2;
            $(document).ready(function() {
                       chart2 = new Highcharts.Chart({
                    chart: {
                renderTo: 'host_total_vuln_rate',
                type: 'line',
                backgroundColor:'rgba(255, 255, 255, 0.1)'

            },
            title: {
                text: 'Top #30 Hosts Total Number Of Vulnerabilities',
                x: -20 //center
            },
            subtitle: {
                text: 'including Critical,High,Medium',
                x: -20
            },
            xAxis: {
                labels: {
                rotation: 90,
                x: 0, y : 45                
            },
                categories: [<?=$_temp_chart_host_vuln_Name?>]
                              
            },
            yAxis: {                
                title: {
                    text: 'Number Of Vulnerabilities'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
                       
            tooltip: {
                formatter: function() {
                        return 'Total Vulnerability : <b> ' + this.y +'</b><br/>'+
                        'Host Name : ' + this.x
                }
            },            
            legend: {
                layout: 'vertical',
                
               
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [{
                name: 'Vulnerability<br>Number',
                data: [<?=$_temp_chart_host_vuln_Count?>]
            }]
                });
            });    
        })(jQuery);
    </script>
    <script type="text/javascript">

        (function($){ // encapsulate jQuery
            var chart3;
            $(document).ready(function() {                    
                    chart3 = new Highcharts.Chart({
            chart: {
                renderTo: 'host_vuln_detail',
                type: 'column',
                backgroundColor:'rgba(255, 255, 255, 0.1)'
            },
            title: {
                text: 'Top #30 Host Vulnerability Details'
            },
            subtitle: {
                text: 'including Medium, High, Critical'
            },
            xAxis: {                
                labels: {
                rotation: 90,
                x: 0, y : 45
                
                
            },
                categories: [<?=$_temp_chart_host_vuln_detail_Name?>]
                
            },
            yAxis: {
                ordinal: false ,
                
                title: {
                    text: 'Number Of Vulnerability'                
                }
            },
            legend: {
                layout: 'vertical',
                backgroundColor: '#FFFFFF',
                align: 'right',
                verticalAlign: 'top',                
                floating: true,
                shadow: true,                
                borderWidth: 0
            },            
            tooltip: {
                formatter: function() {
                    return ''+
                        this.x +': '+ this.y;
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
                series: [{
                name: 'High',
                data: [<?=$_temp_chart_host_vuln_detail_Count_High?>]                    
            },{
                name: 'Critical',
                data: [<?=$_temp_chart_host_vuln_detail_Count_Critical?>]                    
            },{
                name: 'Medium',
                data: [<?=$_temp_chart_host_vuln_detail_Count_Medium?>]                    
            }]
                });
            });    
        })(jQuery);
    </script>    
</head>
<body
    <div>
          <div class="navbar">
              <h2 class="hero">
                  <center>
                    <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>img/logo.png"></a>
                    <small><b>Report Name :</b> <?= html_escape($report_info->ReportName)?></small>                
                    <small><b>Report Owner :</b> <?= html_escape($report_info->UserID)?></small>
                  </center>
              </h2>  		
          </div>
    </div>
    <div class="container">
        <div class="kaydir golge-ve-gecikme"> 
            <br>
            <h5 class="Main-Menu-Mehmet">
                <i class="icon-align-right"></i>Report Information
             </h5>
             <div>
                 <b class ="text-info">Report ID : </b><?=html_escape($report_info->ReportID)?>
             </div>                 
             <br>
             <div>
                 <b class ="text-info">Report Name : </b><?=html_escape($report_info->ReportName)?>
             </div>
             <br>
             <div>
                 <b class ="text-info">Report Owner: </b><?=html_escape($report_info->UserID)?>
             </div>
             <br>
             <div>
                 <b class ="text-info">Report Insert Date: </b><?=html_escape($report_info->InsertDate)?>
             </div>
             <br>
             <div>
                 <b class ="text-info">Report Checksum: </b><?=html_escape($report_info->CheckSum)?>
             </div>
             <br>
             <div>
                 <b class ="text-info">Report Path: </b><i><?=html_escape($report_info->ReportPath)?></i>
             </div>
             <br>
             <div>
                 <b class ="text-info">Report Description: </b><?=html_escape($report_info->ReportDescription)?>
             </div>
             <br>          
        </div>         
    </div>
    <br>
<!--Top 10 Vulnerability Rate-->

    <div class="golge-ve-gecikme">
           <div id="top10_vuln_rate"></div>         
    </div>
<br>    
    <div class="container golge-ve-gecikme">
           <div id="host_total_vuln_rate" ></div>         
    </div>
    <br>
    <div class="container-fluid golge-ve-gecikme">
           <div id="host_vuln_detail"></div>         
    </div>
    <br>
    <div class="container">
        <div class="kaydir golge-ve-gecikme">
            <br>
            <h5 class="Main-Menu-Mehmet">
                <div>
                    <h3>Vulnerabilities Information</h3><br> 
                </div>            
            </h5>
        </div>
    </div>
    <?php
    foreach ($report_data as $vuln_detail) {
        ?>
        <div class="container">
        <div class="kaydir golge-ve-gecikme">
            <h3 class ="text-success"><?=html_escape($vuln_detail->Name)?></h3>
            <div class="row-fluid">
                <div class="span4">
                    <?
                    if($vuln_detail->Severity == 4)
                        echo '<b class="text-warning">Risk Factor : <span class="btn btn-danger disabled">'.html_escape($vuln_detail->RiskFactor)."</span></b>";
                    else if ($vuln_detail->Severity == 3)
                        echo '<b class="text-warning">Risk Factor : <span class="btn btn-warning disabled">'.html_escape($vuln_detail->RiskFactor)."</span></b>";
                    else if ($vuln_detail->Severity == 2)
                        echo '<b class="text-warning">Risk Factor : <span class="btn btn-primary disabled">'.html_escape($vuln_detail->RiskFactor)."</span></b>";
                    else if ($vuln_detail->Severity == 1)
                        echo '<b class="text-warning">Risk Factor : <span class="btn btn-success disabled">'.html_escape($vuln_detail->RiskFactor)."</span></b>";
                    else if ($vuln_detail->Severity == 0)
                        echo '<b class="text-warning">Risk Factor : <span class="btn btn-inverse disabled"> Info </span></b>';
                    ?>                
                </div>            
                <div class="span4">
                    <b class="text-warning">Service Name :</b><?=html_escape($vuln_detail->Service)?>
                </div>    
                <div class="span4">
                     <b class="text-warning">Port / Protocol :</b> <?=html_escape($vuln_detail->Port." / ".$vuln_detail->Protocol)?>
                </div>            
            </div>
            <b class="text-warning">Synopsis</b> : <?=html_escape($vuln_detail->Synopsis)?><br><br>
            <b class="text-warning">Description</b> : <?=html_escape($vuln_detail->Description)?><br><br>
            <b class="text-warning">Solution</b> : <?=html_escape($vuln_detail->Solution)?><br><br>
            <?php if(!empty($vuln_detail->SeeAlso)){ echo '<div><b class="text-warning">See Also</b> : '.html_escape($vuln_detail->SeeAlso).'</div><br>';}?>        
            <?php if(!empty($vuln_detail->CvssBaseScore)){ echo '<div><b class="text-warning">Cvss Base Score</b> : '.html_escape($vuln_detail->CvssBaseScore).'</div><br>';}?>        
            <?php if(!empty($vuln_detail->Cve)){ echo '<div><b class="text-warning">CVE</b> : '.html_escape($vuln_detail->Cve).'</div>';}?>        
            <?php if(!empty($vuln_detail->Bid)){ echo '<div><b class="text-warning">Bid</b> : '.html_escape($vuln_detail->Bid).'</div>';}?>        
            <?php if(!empty($vuln_detail->Xref)){ echo '<div><b class="text-warning">Xref</b> : '.html_escape($vuln_detail->Xref).'</div><br>';}?>
            <?php if(!empty($vuln_detail->VulnPublicationDate)){ echo '<div><b class="text-warning">Vulnerability Publication Date</b> : '.html_escape($vuln_detail->VulnPublicationDate).'</div>';}?>
            <?php if(!empty($vuln_detail->PatchPublicationDate)){ echo '<div><b class="text-warning">Patch Publication Date</b> : '.html_escape($vuln_detail->PatchPublicationDate).'</div>';}?>
            <?php if(!empty($vuln_detail->PluginPublicationDate)){ echo '<div><b class="text-warning">Plugin Publication Date</b> : '.html_escape($vuln_detail->PluginPublicationDate).'</div>';}?>
            <?php if(!empty($vuln_detail->PluginModificationDate)){ echo '<div><b class="text-warning">Plugin Last Modification Date:</b> : '.html_escape($vuln_detail->PluginModificationDate).'</div>';}?>
            <?php 
            if($vuln_detail->ExploitAvailable == 1)
                { 
                echo '<div><b class="text-warning">Exploit Available</b> : YES </div><br>';
                } else { 
                        echo '<div><b class="text-warning">Exploit Available</b> : NO </div><br>';                
                       }
                ?>
            <?php //if($vuln_detail->ExploitFrameworkCanvas == 1){ echo '<div><b class="text-warning">Exploit Framework Canvas</b> : Yes</div>';}?> 
            <?php //if($vuln_detail->ExploitFrameworkCore == 1){ echo '<div><b class="text-warning">Exploit Framework Core</b> : Yes</div>';}?>
            <?php //if($vuln_detail->ExploitFrameworkMetasploit == 1){ echo '<div><b class="text-warning">Exploit Framework Metasploit</b> : Yes</div>';}?>
            <?php //if(!empty($vuln_detail->MetasploitName)){ echo '<div><b class="text-warning">Metasploit Modul </b> :'.  html_escape($vuln_detail->MetasploitName).'</div>';}?>
            <br>
            <span class="btn btn-info disabled"> 
                <b>List Of Hosts</b>
            <table class="table">  
               <thead>  
                 <tr>  
                   <th>#ID</th>  
                   <th>Name</th>  
                 </tr>  
               </thead>  
               <tbody>  
                 <tr>  
                <?php
                $i = 0;
                    foreach ($vuln_detail->HostList as $host) {
                        $i++;
                        echo "<tr>";
                        echo "<td>".$i."</td>";
                        echo "<td>".$host->Name."<td>";
                        echo "</tr>";
                    }
                ?>                  
                 </tr>   
               </tbody>  
             </table>  
            </span>            
        <br>
        <br>
        </div>

        <?
        echo '</div></div>';
    }
    ?>
    <!--/.fluid-container-->
    <div class="container">
        <div class="kaydir golge-ve-gecikme">
            <footer>    
                <div class="row-fluid">
                    <div class="pull-left"><?=$globaldata['companyName']?> </div>
                    <div class="pull-right">Page rendered in <strong>{elapsed_time}</strong> seconds</div>
                </div>
            </footer>        
        </div>
    </div>
</body>
</html>