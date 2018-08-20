<?php

/**
*	Entry point for the application
*/
session_name('cruse_offers');
session_start();

require 'vendor/autoload.php';
require 'CruseLine.php';
?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="style.css">

<?php
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
*	Handle form submittions
*/
if(isset($_POST['submit'])){
	
	//validate for the correct file type
	if($_FILES["offerlist"]['type'] != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
	{
		$error = "<div class='error'>Please upload xlsx file.</div>";
	}
	else{
		$inputFileName = $_FILES["offerlist"]["tmp_name"];
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
		
		//check if the spread sheet is empty 
		if($spreadsheet->getActiveSheet()->getHighestRow()<2){
			$error = "<div class='error'>The file doesn't contain any rows.</div>";
		}
		else{
			
			//if file is valid, get an array of rows from the spreadsheet
			$arrayFromSheet = getSpreadSheetToArray($spreadsheet);
			
			//store an array of CruiseLine objects in the session
			$_SESSION['cruseListArray'] = getCruseLineArrayFromArray($arrayFromSheet);
			
			//output table
			echo "
			<script type=\"text/javascript\" src=\"https://code.jquery.com/jquery-3.3.1.js\"></script>
			<script type=\"text/javascript\" src=\"https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js\"></script>
			<script>
				$(document).ready(function() {
					$('#example').DataTable( {
						\"processing\": true,
						\"ajax\": {\"url\":\"getCruseLiners.php\",\"dataSrc\":\"\"},
						\"columns\": [
							{ \"data\": \"logo\" },
							{ \"data\": \"name\" },
							{ \"data\": \"offerId\" },
							{ \"data\": \"offerName\" },
							{ \"data\": \"departureDate\" },
							{ \"data\": \"itinerary\" },
							{ \"data\": \"shipName\" }
						],
						\"rowCallback\":function(row,data){
							var imgLink = data['logo'];
							var imgTag = '<img src=\"cruiselogos/' + imgLink + '\"/ height=\"30\" width=\"30\">';
							$('td:eq(0)', row).html(imgTag);
							return row;
						}
					} );
				} );
			</script>
			<table id=\"example\" class=\"cruise-list\" style=\"width:100%\">
				<thead>
					<tr>
						<th></th>
						<th>Cruise Line</th>
						<th>OfferId</th>
						<th>Offer</th>
						<th>Departure Date</th>
						<th>Itinerary</th>
						<th>Cruise Ship</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th></th>
						<th>Cruise Line</th>
						<th>OfferId</th>
						<th>Offer</th>
						<th>Departure Date</th>
						<th>Itinerary</th>
						<th>Cruise Ship</th>
					</tr>
				</tfoot>
			</table>";
		}
	}
}

/**
*	Put spread sheet to an array where each row is one element
*	@param	Spreadsheet $spreadsheet
*	@return	array	
*/
function getSpreadSheetToArray($spreadsheet){
	$worksheet = $spreadsheet->getActiveSheet();
	$worksheet->removeRow(1); //get rid of the header 
	$listArray = [];
	foreach($worksheet->getRowIterator() as $row)
	{
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(FALSE);
		$cells = [];
		foreach ($cellIterator as $cell) {		
			array_push($cells,$cell);
		}
		array_push($listArray,$cells);
	}
	return $listArray;
}

/**
*	Map each row of an array to a CruseLine object and store in an array
*	@param	array $arrayFromSheet
*	@return	array	
*/
function getCruseLineArrayFromArray($arrayFromSheet){
	$cruseLineArray = [];
	foreach($arrayFromSheet as $row){
		array_push($cruseLineArray, new CruseLine($row[0]->getValue(),$row[1]->getValue(),\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row[2]->getValue()),$row[3]->getValue(),$row[4]->getValue(),$row[5]->getValue(),$row[6]->getValue()));
	}
	return $cruseLineArray;
}
?>

<div class="container"> 
<form id="fileupload" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST"  enctype="multipart/form-data">
	<fieldset><input name="offerlist" type="file"/></fieldset>
	 <?php if(isset($_FILES["offerlist"]['name']) && isset($error)) echo $error;?>
	<fieldset> <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Upload</button></fieldset>
</form>
</div>	