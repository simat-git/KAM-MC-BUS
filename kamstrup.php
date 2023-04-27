#!/usr/bin/php
<?php
//***********************************
//Kamstrup Multical 302/402 with ID:61 readout and send to mysql database kamstrup.db
//***********************************
$output = shell_exec("sudo /usr/local/bin/mbus-serial-request-data -d -b 2400 /dev/ttyAMA0 228"); //persistant usb drv RPi- "m-busadress 61"
$xmloutput=substr($output,strpos($output,'<MBusData>'));
$xmloutput = new SimpleXMLElement($xmloutput);
$counterID=$xmloutput->SlaveInformation->Id;
$totalpowerValue=$xmloutput->DataRecord[0]->Value;
$heatValue=$xmloutput->DataRecord[1]->Value;
$coolValue=$xmloutput->DataRecord[2]->Value;
$ontimeheatValue=$xmloutput->DataRecord[6]->Value;
$ontimecoolValue=$xmloutput->DataRecord[7]->Value;
$tempoutValue=$xmloutput->DataRecord[8]->Value;
$tempreturnValue=$xmloutput->DataRecord[9]->Value;
$tempdiffValue=$xmloutput->DataRecord[10]->Value;
$powerinstValue=$xmloutput->DataRecord[11]->Value;
$powermaxValue=$xmloutput->DataRecord[12]->Value;
$flowinstValue=$xmloutput->DataRecord[13]->Value;
$flowmaxValue=$xmloutput->DataRecord[14]->Value;
$heatenergymonthValue=$xmloutput->DataRecord[15]->Value;
$coolenergymonthValue=$xmloutput->DataRecord[16]->Value;

$DomoticzIP="http://127.0.0.1:8080/";
$IDXTaanvoer=9;
$IDXTretour=10;
$IDXTdiff=12;
$IDXHeat=444;
$IDXCool=445;
$IDXFlow=8;
$IDXTotalPower=11;
$IDXPower=13; //in Domoticz: type counter / energy?
$IDXHeatMonth=449; //in Domoticz:
$IDXCoolMonth=450; //in Domoticz:


//Function to send to Domoticz
    function ud($idx,$nvalue,$svalue,$name=""){
        print "  --- UPDATE ".$idx." ".$name." ".$nvalue." ".$svalue."
    ";
        file_get_contents("http://127.0.0.1:8080/".'json.htm?type=command&param=udevice&idx='.$idx.'&nvalue='.$nvalue.'&svalue='.$svalue);
        usleep(250000);
    }

//Function counter to send to Domoticz
    function uc($idx,$svalue,$name=""){
        print "  --- UPDATE ".$idx." ".$name." ".$svalue."
    ";
        file_get_contents("http://127.0.0.1:8080/".'json.htm?type=command&param=udevice&idx='.$idx.'&svalue='.$svalue);
        usleep(250000);
    }


// Total MWh kamstrup reg 0
ud($IDXTotalPower,0,$totalpowerValue,0);

// Taanvoer (K) to Domoticz (kamstrup Reg 8)
ud($IDXTaanvoer,0,$tempoutValue/100,0);

// Tretour (K) to Domoticz (kamstrup Reg 9)
ud($IDXTretour,0,$tempreturnValue/100,0);

// Tdiff (K) to Domoticz (kamstrup Reg 10)
ud($IDXTdiff,0,$tempdiffValue/100,0);

// Instant Heat (kWh) to Domoticz (kamstrup Reg 1)
//ud($IDXHeat,0,$heatValue,0);

// Instant Cool (kWh) Domoticz (kamstrup Reg 2)
//ud($IDXCool,0,$coolValue,0);

// Instant flow (ltr/h) to Domoticz (kamstrup Reg 13)
ud($IDXFlow,0,$flowinstValue,0);

// Instant Power (watt) to Domoticz (kamstrup Reg 11)
//ud($IDXPower,0,$powerinstValue*100,0);

ud(14,0,$powerinstValue*100,0);
//ud(16,0,$powerinstValue*100,0);

// Total Heat power last month (kWh) to Domoticz (kamstrup Reg 15)
//ud($IDXHeatMonth,0,$heatenergymonthValue,0);

// Total Cool power last month (kWh) to Domoticz (kamstrup Reg 16)
//ud($IDXCoolMonth,0,$coolenergymonthValue*100,0);

//*************************************
// mysql
//*************************************
// working, but not further developed with this script

//$mysqlhost="localhost";
//$mysqluser="root";
//$mysqlpwd="raspberry";
//$connection=mysql_connect($mysqlhost,$mysqluser,$mysqlpwd) or die ("verbindings fout");
//$mysqldb="kamstrup";
//mysql_select_db($mysqldb,$connection) or die("Konnte die Datenbank nicht waehlen.");

//$sql = "INSERT INTO kamstrup (timevalue,fab_nr,energy_heat_inst,energy_cool_inst,onetimeheat,onetimecool,tempout,tempreturn,tempdiff,powerinst,powermax,flowinst,flowmax) VALUES (CURRENT_TIMESTAMP,$counterID,$heatValue,$coolValue,$ontimeheatValue,$ontimecoolValue,$tempoutValue,$tempreturnValue,$tempdiffValue,$powerinstValue,$powermaxValue,$flowinstValue,$flowmaxValue)";

//$result = mysql_query($sql); 
//if(!$result) 
//{ 
//   error_log("Query error ($sql): " . mysql_error()); 
//   echo "<p class='error'>Sorry, er was een database error.</p>"; 
//   echo "</body></html>"; 
//  exit; 
//} 

?>
