<?php

namespace PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdvertController extends Controller
{
	
	public function indexAction($page)
	{
		// On ne sait pas combien de pages il y a
		// Mais on sait qu'une page doit être supérieure ou égale à 1
		if ($page < 1) {
			// On déclenche une exception NotFoundHttpException, cela va afficher
			// une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)
			throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
		}
		$listAdverts = array(
				array(
						'title'   => 'Recherche développpeur Symfony2',
						'id'      => 1,
						'author'  => 'Alexandre',
						'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
						'date'    => new \Datetime()),
				array(
						'title'   => 'Mission de webmaster',
						'id'      => 2,
						'author'  => 'Hugo',
						'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
						'date'    => new \Datetime()),
				array(
						'title'   => 'Offre de stage webdesigner',
						'id'      => 3,
						'author'  => 'Mathieu',
						'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
						'date'    => new \Datetime())
		);
		// Ici, on récupérera la liste des annonces, puis on la passera au template
	
		// Mais pour l'instant, on ne fait qu'appeler le template
	return $this->render('PlatformBundle:Advert:index.html.twig', array(
  'listAdverts' => $listAdverts ));
	}
	
  	
// On injecte la requête dans les arguments de la méthode
  public function viewAction($id)
  {
       $advert = array(
      'title'   => 'Recherche développpeur Symfony2',
      'id'      => $id,
      'author'  => 'Alexandre',
      'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
      'date'    => new \Datetime()
    );

    return $this->render('PlatformBundle:Advert:view.html.twig', array(
      'advert' => $advert
    ));
  }
	
  
 public function addAction(Request $request)
  {
    // On récupère le service
    $antispam = $this->container->get('oc_platform.antispam');

    // Je pars du principe que $text contient le texte d'un message quelconque
    $text = 'hegehehj(';
    if ($antispam->isSpam($text)) {
      throw new \Exception('Votre message a été détecté comme spam !');
    }
    return  new Response($text);
    // Ici le message n'est pas un spam
  }
  
  
  public function editAction($id, Request $request)
  {
  	// Ici, on récupérera l'annonce correspondante à $id
  
  	// Même mécanisme que pour l'ajout
  	if ($request->isMethod('POST')) {
  		$request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
  
  		return $this->redirectToRoute('oc_platform_view', array('id' => 5));
  	}
  
  	  $advert = array(
      'title'   => 'Recherche développpeur Symfony2',
      'id'      => $id,
      'author'  => 'Alexandre',
      'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
      'date'    => new \Datetime()
    );

    return $this->render('PlatformBundle:Advert:edit.html.twig', array(
      'advert' => $advert
    ));
  }
  
  public function deleteAction($id)
  {
  	// Ici, on récupérera l'annonce correspondant à $id
  
  	// Ici, on gérera la suppression de l'annonce en question
  
  	return $this->render('PlatformBundle:Advert:delete.html.twig');
  }
  
	public function viewSlugAction($_format, $year, $slug)
	{
		return new Response(
				"On pourrait afficher l'annonce correspondant au
            slug '".$slug."', créée en ".$year." et au format ".$_format."."
				);
	}
	
	public function menuAction()
	{
		// On fixe en dur une liste ici, bien entendu par la suite
		// on la récupérera depuis la BDD !
		$listAdverts = array(
				array('id' => 2, 'title' => 'Recherche développeur Symfony2'),
				array('id' => 5, 'title' => 'Mission de webmaster'),
				array('id' => 9, 'title' => 'Offre de stage webdesigner')
		);
	
		return $this->render('PlatformBundle:Advert:menu.html.twig', array(
				// Tout l'intérêt est ici : le contrôleur passe
				// les variables nécessaires au template !
				'listAdverts' => $listAdverts
		));
	}
	

}
