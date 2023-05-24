<?php

declare(strict_types=1);
	class ERSLite extends IPSModule
	{
		public function Create()
		{
			//Never delete this line!
			parent::Create();
			
			
			$this->ConnectParent('{C6D2AEB3-6E1F-4B2E-8E69-3A1A00246850}');
			//$this->createVariablenProfiles();
			$this->RegisterPropertyString('Topic', "");
			
			 //Variablen anlegen
			$this->RegisterVariableString("Name", "Gerätname", "",1);
			$this->RegisterVariableFloat("Temp", "Temperatur", "",1);
			$this->RegisterVariableFloat("Hum", "Luftfeuchte", "",2);
			$this->RegisterVariableInteger("Batt", "Batterie", "",3);
			
			$this->RegisterVariableString("Time", "Timestamp", "",20);
						
	
		}

		public function Destroy()
		{
			//Never delete this line!
			parent::Destroy();
		}

		public function ApplyChanges()
		{
			//Never delete this line!
			parent::ApplyChanges();
			$MQTTTopic = $this->ReadPropertyString('Topic');
        		$this->SetReceiveDataFilter('.*' . $MQTTTopic . '.*');
		}
		
		public function ReceiveData($JSONString)
    	{
       	 	$this->SendDebug('JSON', $JSONString, 0);
        	if (!empty($this->ReadPropertyString('Topic'))) {
            	$Buffer = json_decode($JSONString);
           	 	// Buffer decodieren und in eine Variable schreiben
           	 	$this->SendDebug('MQTT Topic', $Buffer->Topic, 0);
          	  	$this->SendDebug('MQTT Payload', $Buffer->Payload, 0);
				if (property_exists($Buffer, 'Topic')) {
               	 if (fnmatch('*/up', $Buffer->Topic)) 		{
					
						$api=$Buffer->Payload;
						$daten=json_decode($api,true);
						//$this->SendDebug('Receive Result: api', $daten["deviceName"], 0);
						$daten1=json_decode($daten["objectJSON"],true);
						//$this->SendDebug('Receive Result: api1', $daten1["data"][0]["value"], 0);	
						
						$Device=$daten["deviceName"];
						//$this->SendDebug('Receive Result: api', $Device, 0);
						SetValue($this->GetIDForIdent('Name'),$Device);
						$Temp=$daten1["data"][0]["value"];
						SetValue($this->GetIDForIdent('Temp'),$Temp);
						$Time=$daten1["data"][0]["time"];
						SetValue($this->GetIDForIdent('Time'),$Time);
						$Hum=$daten1["data"][1]["value"];
						SetValue($this->GetIDForIdent('Hum'),$Hum);
						$Batt=$daten1["data"][2]["value"];
						SetValue($this->GetIDForIdent('Batt'),$Batt);
						
						
				    }
				}
			
		}	
		}	
	}