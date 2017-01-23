<?php
		debug_to_console("Search Criteria: ".$tag);
    $api_key = '96cbe4cb0d6f28b358b00a0985199cc8'; 
    $perPage = 3; //number of pictures per page
    $url = 'https://api.flickr.com/services/rest/?method=flickr.photos.search';
    $url.= '&api_key='.$api_key;
    $url.= '&tags='.$tag;
    $url.= '&per_page='.$perPage;
    $url.= '&format=json'; //format of response
    $url.= '&nojsoncallback=1';
    $url1.= $url.'&page=1';
    //$url.='&geo_context=2';
    $responseflickr1 = json_decode(file_get_contents($url1),true);
		//used to find out how many pages are available to random through
			$total_pages = $responseflickr1['photos']['pages'];
			debug_to_console("Number of Flickr pages: ".$total_pages);
			$url2.=$url.'&page='.rand(1, $total_pages);
		$responseflickr = json_decode(file_get_contents($url2),true);
	  $picture1 = "https://farm".$responseflickr['photos']['photo'][0]['farm'].".staticflickr.com/".$responseflickr['photos']['photo'][0]['server']."/".$responseflickr['photos']['photo'][0]['id']."_".$responseflickr['photos']['photo'][0]['secret'].".jpg";
    $title1 = $responseflickr['photos']['photo'][0]['title'];
    $picture2 = "https://farm".$responseflickr['photos']['photo'][1]['farm'].".staticflickr.com/".$responseflickr['photos']['photo'][1]['server']."/".$responseflickr['photos']['photo'][1]['id']."_".$responseflickr['photos']['photo'][1]['secret'].".jpg";
    $title2 = $responseflickr['photos']['photo'][1]['title'];
    $picture3 = "https://farm".$responseflickr['photos']['photo'][2]['farm'].".staticflickr.com/".$responseflickr['photos']['photo'][2]['server']."/".$responseflickr['photos']['photo'][2]['id']."_".$responseflickr['photos']['photo'][2]['secret'].".jpg";
    $title3 = $responseflickr['photos']['photo'][2]['title'];
		debug_to_console("Flickr response ".$url2);
		debug_to_console($responseflickr);
		debug_to_console($picture1);
?>