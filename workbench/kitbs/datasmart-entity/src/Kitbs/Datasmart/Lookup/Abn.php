<?php namespace Kitbs\Datasmart\Lookup;

use SoapClient;
use stdClass;

class Abn extends SoapClient {

	private $guid = ""; 
	
	public function __construct($guid)
	{
		$this->guid = $guid;
		$params = array(
			'soap_version' => SOAP_1_1,
			'exceptions' => true,
			'trace' => 1,
			'cache_wsdl' => WSDL_CACHE_NONE
			); 

		parent::__construct('http://abr.business.gov.au/abrxmlsearch/ABRXMLSearch.asmx?WSDL', $params);
	}
	
	public function debug()
	{
		echo $this->__getLastRequest();
	}

	public function searchByABN($abn, $historical = 'N')
	{
		$params = new stdClass();
		$params->searchString             = $abn;
		$params->includeHistoricalDetails = $historical;
		$params->authenticationGuid       = $this->guid;
		return $this->ABRSearchByABN($params);
	}

	public function searchByName($name, $historical = 'N')
	{
		$params = new stdClass();
		$params->externalNameSearch          = new stdClass();
		$params->externalNameSearch->name    = $name;
		$params->externalNameSearch->filters = new stdClass();

		$params->externalNameSearch->filters->nameType = new stdClass();
		$params->externalNameSearch->filters->nameType->tradingName = 'Y';
		$params->externalNameSearch->filters->nameType->legalName = 'Y';
		$params->externalNameSearch->filters->stateCode = new stdClass();
		$params->externalNameSearch->filters->stateCode->QLD = 'Y';
		$params->externalNameSearch->filters->stateCode->NT = 'Y';
		$params->externalNameSearch->filters->stateCode->SA = 'Y';
		$params->externalNameSearch->filters->stateCode->WA = 'Y';
		$params->externalNameSearch->filters->stateCode->VIC = 'Y';
		$params->externalNameSearch->filters->stateCode->ACT = 'Y';
		$params->externalNameSearch->filters->stateCode->TAS = 'Y';
		$params->externalNameSearch->filters->stateCode->NSW = 'Y';

		$params->externalNameSearch->minimumScore = 60;
		$params->externalNameSearch->searchWidth = 'Narrow';
		
		$params->authenticationGuid = $this->guid;

		return $this->ABRSearchByNameAdvanced($params);
		
	}

}