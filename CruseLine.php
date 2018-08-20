<?php
/**
*	Define the CruseLine model
*/
class CruseLine{
	
	/**
	*	value of the offer Id
	*/
	private $offerId;
	
	/**
	*	value of the offer Name
	*/
	private $offerName;
	
	/**
	*	value of the depature date
	*/
	private $departureDate;
	
	/**
	*	value of the itinerary
	*/
	private $itinerary;
	
	/**
	*	value of the cruise name
	*/
	private $name;
	
	/**
	*	value of the jpeg file for the logo
	*/
	private $logo;
	
	/**
	*	value of the ship name
	*/
	private $shipName;
	
	/**
	*	Create a new cruse line
	*
    * 	@param string $offerId
    * 	@param string $offerName
    * 	@param string $departureDate
    * 	@param string $itinerary
    * 	@param string $name
    * 	@param string $logo
    * 	@param string $shipName
	*/
	function __construct($offerId='',$offerName='',$departureDate='',$itinerary='',$name='',$logo='',$shipName=''){
		$this->offerId = $offerId;
		$this->offerName = $offerName;
		$this->departureDate = $departureDate;
		$this->itinerary = $itinerary;
		$this->name = $name;
		$this->logo = $logo;
		$this->shipName = $shipName;
	}
	
	public function getOfferId(){
		return $this->offerId;
	}
	
	public function setOfferId($value){
		$this->offerId = $value;
	}
	
	public function getOfferName(){
		return $this->offerName;
	}
	
	public function setOfferName($value){
		$this->offerName = $value;
	}
	public function getDepartureDate(){
		return $this->departureDate;
	}
	
	public function setDepartureDate($value){
		$this->departureDate = $value;
	}
	public function getItinerary(){
		return $this->itinerary;
	}
	
	public function setItinerary($value){
		$this->itinerary = $value;
	}
	public function getName(){
		return $this->name;
	}
	
	public function setName($value){
		$this->name = $value;
	}
	public function getLogo(){
		return $this->logo;
	}
	
	public function setLogo($value){
		$this->logo = $value;
	}
	public function getShipName(){
		return $this->shipName;
	}
	
	public function setShipName($value){
		$this->shipName = $value;
	}	
}