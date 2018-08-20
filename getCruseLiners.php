<?php

/**
*	Return all the cruise line date stored in the current session
*	to the front end as a JSON.
*/
require 'CruseLine.php';

session_name('cruse_offers');
session_start();

$json_data = [];
foreach($_SESSION['cruseListArray'] as $cruseLins){
	array_push( $json_data,[
				'offerId'=>$cruseLins->getOfferId(),
				'offerName'=>$cruseLins->getOfferName(),
				'departureDate'=>date("l, d M Y",$cruseLins->getDepartureDate()),
				'itinerary'=>$cruseLins->getItinerary(),
				'name'=>$cruseLins->getName(),
				'logo'=>$cruseLins->getLogo(),
				'shipName'=>$cruseLins->getShipName()]
	);
}

echo json_encode($json_data);