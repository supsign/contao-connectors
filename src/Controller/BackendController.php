<?php

namespace Supsign\ContaoConnectorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Contao\MemberModel;
use Contao\MemberGroupModel;

/**
 * @Route("/contao", defaults={
 *     "_scope" = "backend",
 *     "_token_check" = false,
 *     "_backend_module" = "connectors-bundle"
 * })
 */
class BackendController extends AbstractController
{

    /**
     * @Route("/ftpconnector", name="supsign.ftpconnector")
     */

    public function default()
    {

    	// $query = MemberModel::findOneById(16);

    	// var_dump($query);

    	// $query = MemberModel::findOneById(35);

    	// var_dump($query);

    	// var_dump($_POST);

    	$submit = extract($_POST) > 0;

    	$members = MemberModelAdvanced::findOneById(20);

    	var_dump($members);

    	if ($submit) {
	    	// $query = MemberModel::findByGroups($selectedMemberGroups);

    		// // $query = MemberModel::findBy()


	    	// var_dump($query);

	    	// foreach ($selectedMemberGroups AS $selectedMemberGroup) {
		    // 	$query = MemberModel::findOneByGroups($selectedMemberGroup);
		    // 	var_dump($query);
	    	// }
    	}


    	$data = [
    		'memberGroups' => MemberGroupModel::findAll()
    	];

        return new Response(
            $this->get('twig')->render('default.html.twig', $data)
        );
    }
}
