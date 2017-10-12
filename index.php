<?php

/**
 * Application d'exemple Agence de voyages Silex
 */





//echo "we just keep on trying till we run out of cake";



// require_once __DIR__.'/vendor/autoload.php';
$vendor_directory = getenv ( 'COMPOSER_VENDOR_DIR' );
if ($vendor_directory === false) {
	$vendor_directory = __DIR__ . '/vendor';
}
require_once $vendor_directory . '/autoload.php';

// Initialisations
$app = require_once 'initapp.php';

require_once 'agvoymodel.php';

// Routage et actions


//Page accueil(html.twig à fair)

$app->get('/', 
		function () use ($app)
		{
			return $app ['twig']->render('accueil.html.twig');
}
);

// circuitlist : Liste tous les circuits
$app->get ( '/circuit', 
    function () use ($app) 
    {
    	$circuitslist = get_all_circuits ();
    	$programmations= get_all_programmations();
    	$plannedcircuitslist=get_all_distinct_planned_circuits();
    	//print_r($plannedcircuitslist);
    	
    	return $app ['twig']->render ( 'FrontOffice/circuitslist.html.twig', [
    			'circuitslist' => $circuitslist, 'programmationslist'=>$programmations, 'plannedcircuitslist'=>$plannedcircuitslist
    	] );
    }
)->bind ( 'circuitlist' );

// circuitshow : affiche les détails d'un circuit
$app->get ( '/circuit/{id}', 
	function ($id) use ($app) 
	{	
		$etapes= get_all_etapes_by_circuit_id($id);
		$circuit = get_circuit_by_id ( $id );
	    //print_r($etapes);
		

		return $app ['twig']->render ( 'FrontOffice/circuitshow.html.twig', [ 
				'id' => $id,
				'circuit' => $circuit ,
				'etapes' => $etapes,
			] );
	}
)->bind ( 'circuitshow' );

// programmationlist : liste tous les circuits programmés
$app->get ( '/programmation', 
	function () use ($app) 
	{
		$programmationslist = get_all_programmations ();
		// print_r($programmationslist);

		return $app ['twig']->render ( 'FrontOffice/programmationslist.html.twig', [ 
				'programmationslist' => $programmationslist 
			] );
	}
)->bind ( 'programmationlist' );

$app->run ();
