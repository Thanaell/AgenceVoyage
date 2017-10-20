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
)->bind ('accueil');

$app->get('/admin',
    function () use ($app)
    {
        return $app ['twig']->render('BackOffice/accueilB.html.twig');
    }
)->bind ('accueiladmin');

$app->get('/admin/modifcircuit',
    function () use ($app)
    {
        return $app ['twig']->render('BackOffice/modifcircuit.html.twig');
    }
)->bind ('modifcircuit');


$app->get('/admin/modifprogrammation',
    function () use ($app)
    {
        return $app ['twig']->render('BackOffice/modifprogrammation.html.twig');
    }
)->bind ('modifprogrammation');


// circuitlist : Liste tous les circuits planifiés, pour le frontoffice
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

// circuitlist : Liste tous les circuits, pour le back office
$app->get ( '/admin/circuit',
    function () use ($app)
    {
        $circuitslist = get_all_circuits ();
        $programmations= get_all_programmations();
        //print_r($circuitslist);

        return $app ['twig']->render ( 'BackOffice/circuitslistB.html.twig', [
            'circuitslist' => $circuitslist, 'programmationslist'=>$programmations,
        ] );
    }
)->bind ( 'circuitlistadmin' );

//

// circuitshow : affiche les détails d'un circuit, pour le front office
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



// circuitshow : affiche les détails d'un circuit, pour le Back Office
$app->get ( '/admin/circuit/{id}',
    function ($id) use ($app)
    {
        $etapes= get_all_etapes_by_circuit_id($id);
        $circuit = get_circuit_by_id ( $id );
        //print_r($etapes);


        return $app ['twig']->render ( 'BackOffice/circuitsshowB.html.twig', [
            'id' => $id,
            'circuit' => $circuit ,
            'etapes' => $etapes,
        ] );
    }
)->bind ( 'circuitshowadmin' );

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

// programmationlist : liste tous les circuits programmés, pour le BackOffice
$app->get ( '/admin/programmation',
		function () use ($app)
		{
			$programmationslist = get_all_programmations ();
			// print_r($programmationslist);
			
			return $app ['twig']->render ( 'BackOffice/programmationslistB.html.twig', [
					'programmationslist' => $programmationslist
			] );
}
)->bind ( 'programmationlistadmin' );

$app->run ();
