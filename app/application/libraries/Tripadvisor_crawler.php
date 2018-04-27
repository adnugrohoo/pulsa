<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tripadvisor_crawler {

	public function __construct(){

	}
	
	function get_string_between($string, $start, $end){
		$string = " ".$string;
		$ini = strpos($string,$start);
		if ($ini == 0) return "";
		$ini += strlen($start);
		$len = strpos($string,$end,$ini) - $ini;
		return substr($string,$ini,$len);
	}


	function depurate ($string) {
		$string = strip_tags($string);
		// Erase the comma as thousand separator
		$string = str_replace(',', '', $string);
		// Some manual strings
		$string = str_replace("\n", '', $string); //NB \n requires double quotes
		$string = str_replace('More', '', $string);
		$string = str_replace('Was this review helpful?', '', $string);
		$string = htmlentities($string);
		return $string;
	}
	
	function abs_number($number){
		return abs((int) filter_var($number, FILTER_SANITIZE_NUMBER_INT));
	}
	
	function get_id($string=''){
		$curl = curl_init();
		$string = urlencode($string);
		//echo "https://www.tripadvisor.com/TypeAheadJson?query=$string&types=hotel%2Ceat%2Cattr&action=API";
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://www.tripadvisor.com/TypeAheadJson?query=$string&types=hotel&action=API",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "postman-token: cfa9d672-e980-c420-69a1-308db2cdb955"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "get_id cURL Error #:" . $err;
		} else {
		  return json_decode($response);
		}
	}
	
	function get_data($id, $coordinate){
		
		$koordinat = $coordinate;
		$tripAdvisorUniqueID = $id;
		
		if (isset($tripAdvisorUniqueID) && $tripAdvisorUniqueID != NULL) {

			// Retrieve all the client-side code of the page requested
			//$pageContent = file_get_contents('http://www.tripadvisor.com/'.$tripAdvisorUniqueID);
			// $curl = curl_init('http://www.tripadvisor.com/'.$tripAdvisorUniqueID);
			// curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
			// curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
			// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		     // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		     // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		     // curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
		     // curl_setopt($curl, CURLOPT_TIMEOUT, 3);
		     // curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/html'));
			// $pageContent = curl_exec($curl);

			// if(curl_errno($curl)) // check for execution errors
			// {
				// echo 'Scraper error: ' . curl_error($curl);
				// exit;
			// }

			// curl_close($curl);
			
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, 'http://www.tripadvisor.com/'.$tripAdvisorUniqueID);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);  
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 3);     
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_COOKIEJAR,  dirname(__FILE__) . "/cookie.txt");
			curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
			$pageContent = curl_exec($ch);
			curl_close($ch);
			
			/////////////////
			// Extract Location Name 
			//$REGEX_name = '/<title>(.*?) - (.*?) TripAdvisor<\/title>/is'; ### Fine tune/edit if needed
			
			//$itemNameExtracted = preg_match_all($REGEX_name, $pageContent, $itemNameMatches);
			//$itemName = $itemNameMatches[1][0];
			$itemName = $this->get_string_between($pageContent,'"hotelName":"' ,'","');
			//if($itemName == '') $itemName = get_string_between($pageContent,'<h1 id="HEADING" class="ui_header h1">' ,'</h1>');

			/////////////////
			//Extract Total Number of Reviews
			// Match substring between start and end strings using funcion get_string_between
			$REGEX_NtotalReviews = array (  ### Fine tune/edit if needed
				array('<span property="count">','</span>'),	
				array('class="tabs_header reviews_header">',' Reviews'),
				array('<span class="reviews_header_count">','</span>'),
				array('reviews_header">',' reviews'),	
			);	
			$numberTotalReviews = $this->get_string_between($pageContent, $REGEX_NtotalReviews[0][0],$REGEX_NtotalReviews[0][1]);
			//echo $numberTotalReviews.'xx';
			// if there is no match (the code in the page is slightly different sometimes) try other strings
				for ($i = 1; $numberTotalReviews == null && $i < sizeof($REGEX_NtotalReviews); $i++) {
					$numberTotalReviews = $this->get_string_between($pageContent, $REGEX_NtotalReviews[$i][0], $REGEX_NtotalReviews[$i][1]);
					$numberTotalReviews = $this->abs_number($numberTotalReviews);
				}	
			$numberTotalReviews = $this->depurate($numberTotalReviews);
			
			
			//<span class="overallRating">4.5 </span>
			//RATING
			$numberRating = $this->get_string_between($pageContent, '<span class="overallRating">','</span>'); 
			$numberRating=$this->abs_number($numberRating);
			
			//<div>5.0 Star Hotel</div>
			//STAR
			$star = $this->get_string_between($pageContent, '</DIV><div>','Star Hotel</div>');
			$star=$this->abs_number($star);
			//echo $this->abs_number('<span class="fill" style="width:100%;"></span>');
			/////////////////
			// Extract Numbers of reviews by type <span class="fill" style="width:7%;"></span>
			$REGEX_typeOfReview = '/<span class="fill" style="(.*?)<\/span>/is';  ### Fine tune/edit if needed
			
			$typeOfReview = preg_match_all($REGEX_typeOfReview, $pageContent, $reviewsMatches);
			//echo'<pre>';print_r($reviewsMatches);
			
			if (isset($reviewsMatches[0][0])) $numberExcellentReviews = $this->abs_number($reviewsMatches[0][0]);
			else $numberExcellentReviews = 0; //Excellent
			
			if (isset($reviewsMatches[0][1])) $numberVeryGoodReviews = $this->abs_number($reviewsMatches[0][1]);
			else $numberVeryGoodReviews = 0; //Very Good
			
			if (isset($reviewsMatches[0][2])) $numberAverageReviews = $this->abs_number($reviewsMatches[0][2]);
			else $numberAverageReviews = 0; //Average
			
			if (isset($reviewsMatches[0][3])) $numberPoorReviews = $this->abs_number($reviewsMatches[0][3]);
			else $numberPoorReviews = 0; //Poor
			
			if (isset($reviewsMatches[0][4])) $numberTerribleReviews = $this->abs_number($reviewsMatches[0][4]);
			else $numberTerribleReviews = 0; //Terrible
			
			
			//FASILITAS
			// Extract FASILITAS //<div class="highlightedAmenity detailListItem">Free Wifi</div>
			//$REGEX_fasilitas = '/<div class="highlightedAmenity detailListItem">(.*?)<\/div>/is';  ### Fine tune/edit if needed
			$REGEX_fasilitas = '/<div class="textitem" data-prwidget-name="text" data-prwidget-init="">(.*?)<\/div>/is';
			$fasilitas2 = []; $locationTree = ''; $RoomType='';
			preg_match_all($REGEX_fasilitas, $pageContent, $fasilitas);
			
			foreach($fasilitas as $valArr){
				foreach($valArr as $val){
					if(!preg_match('/^.*(,|#|IDR|&gt;|[0-9]|TripAdvisor|homestay|Indonesia).*$/',$val)){
						//echo($val);
						//$val = html_entity_decode($val);
						if(!in_array($val, $fasilitas2)){
							$fasilitas2[] = $val;
						}
					}elseif(preg_match('/^.*(&gt;).*$/',$val)){
						 $locationTree = $val; //location tree
						 $locationTree = preg_replace('/\s*&gt;\s*/', ',', $locationTree);
					}elseif(preg_match('/^.*(,).*$/',$val)&&!preg_match('/^.*(#|IDR|&gt;|[0-9]|TripAdvisor).*$/',$val)){
						 $RoomType = $val; //location tree
						 $RoomType = preg_replace('/\s*,\s*/', ',', $RoomType);
					}
					
				}
			}
			
			//Address
			/*
			<div class="content hidden">
			<span class="street-address">Jl. Palm _ Papandayan, Gajahmungkur</span> | 
			<span class="extended-address">Palm Hill Estate</span>, 
			<span class="locality">Semarang 50232, </span>
			<span class="country-name">Indonesia</span>
			</div>
			*/
			$street = $this->get_string_between($pageContent, '<span class="street-address">','</span>');
			$street = $this->depurate($street);
			$extended = $this->get_string_between($pageContent, '<span class="extended-address">','</span>');
			$extended = $this->depurate($extended);
			$locality = $this->get_string_between($pageContent, '<span class="locality">','</span>');
			$locality = $this->depurate($locality);
			$country = $this->get_string_between($pageContent, '<span class="country-name">','</span>');
			$country = $this->depurate($country);
			
			
			//ALL image
			$doc = new DOMDocument();
			@$doc->loadHTML($pageContent);

			$tags = $doc->getElementsByTagName('img');
			$images = [];
			foreach ($tags as $tag) {
				//(strpos($tag->getAttribute('src'), 'https://media-cdn.tripadvisor.com/') AND strpos
				   if (strpos($tag->getAttribute('src'), 'https://media-cdn.tripadvisor.com/') !== false) {
						 $images []= $tag->getAttribute('src');
					}
			}			
			
			//<span class="overallRating">4.5 </span>
			//koordinat
			//$koordinat = get_string_between($pageContent, '&amp;markers=','&amp;');
			//$koordinat=depurate($koordinat);
			
			/////////////////
			// Match traveler reviews
			$REGEX_travelerReviews = '/<p class="partial_entry">(.*?)<\/span>/is'; ### Fine tune/edit if needed
			$count = preg_match_all($REGEX_travelerReviews, $pageContent, $matches);
			
			if($count <1) {
				$REGEX_travelerReviews = '/<p class="partial_entry" >(.*?)<\/span>/is'; ### Fine tune/edit if needed
				$count = preg_match_all($REGEX_travelerReviews, $pageContent, $matches);
			}
			
			$REGEX_travelerReviewsIgnore = 'response_'; ### Fine tune/edit if needed
			$matchedUserReviews = array();
			
			for ($i = 0; $i < $count; ++$i) {
				//Ignore Responses by managers
				if (strpos($matches[0][$i],$REGEX_travelerReviewsIgnore) === false) {
					$matchedUserReviews[] = $this->depurate($matches[0][$i]);
				}
			}

			
			//Create Output
			$output = array(
				"TripAdvisorID" => $tripAdvisorUniqueID,
				"LocationName" => $itemName,
				"NumberOfReviews" => array(
					"total" => $numberTotalReviews,
					"Excellent" => $numberExcellentReviews,
					"VeryGood" => $numberVeryGoodReviews,
					"Average" => $numberAverageReviews,
					"Poor" => $numberPoorReviews,
					"Terrible" => $numberTerribleReviews
				),
				'address'=> array(
					'street'=>$street,
					'extended'=>$extended,
					'locality'=>$locality,
					'country'=>$country,
					),
				'LocationTree'=>$locationTree,
				'Rating' => $numberRating,
				'Star' => $star,
				'fasilitas'=>$fasilitas2,
				'RoomType'=>$RoomType,
				'coords'=>$koordinat,
				"Last10Reviews" => $matchedUserReviews,
				'images'=>$images
			);

			//Print Output in JSON Format
			//echo json_encode($output);
			//echo "<pre>";print_r($output);
			//echo htmlentities($pageContent);
			
			return($output);

		}
	}

}