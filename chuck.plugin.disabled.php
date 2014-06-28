<?php
/*
@name Chuck
@author Clement quintard 
@link http://quintard.me
@licence CC by nc sa
@version 1.0.0
le plugin 
*/



function chuckinfo_vocal_command(&$response,$actionUrl){
	global $conf;
	$response['commands'][] = array(
		'command'=>$conf->get('VOCAL_ENTITY_NAME').' raconte moi chuck',
		'url'=>$actionUrl.'?action=chuckinfo_action','confidence'=>'0.85'
		);
		
}

function chuckinfo_action()
{
	global $_,$conf;

	switch($_['action'])
	{
		case 'chuckinfo_action':
					global $_;
					
						$url = 'http://www.chucknorrisfacts.fr/api/get?data=tri:alea;nb:1';
						$ch = curl_init($url);
						curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; fr-FR; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1" ); 
						$c = curl_exec($ch);

						$json = json_decode($c);
						
						$content = $json[0]->fact;
						$affirmation = html_entity_decode($content, ENT_QUOTES); 

						$affirmation = preg_replace("(\r\n|\n|\r)",'',$affirmation);
						$response = array('responses'=>array(
											array('type'=>'talk','sentence'=>$affirmation)
														)
										);
						$json = json_encode($response);
						echo ($json=='[]'?'{}':$json);
				break;
	}
}





Plugin::addHook("action_post_case", "chuckinfo_action");  
Plugin::addHook("vocal_command", "chuckinfo_vocal_command");
?>