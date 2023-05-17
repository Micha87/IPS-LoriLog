<?php

declare(strict_types=1);
	class ELTLite extends IPSModule
	{
		public function Create()
		{
			//Never delete this line!
			parent::Create();
			
			
			$this->ConnectParent('{C6D2AEB3-6E1F-4B2E-8E69-3A1A00246850}');
			$this->createVariablenProfiles();
			$this->RegisterPropertyString('Topic', "");
	
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
	}
