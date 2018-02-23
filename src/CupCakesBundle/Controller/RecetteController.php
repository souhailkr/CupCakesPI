<?php

namespace CupCakesBundle\Controller;

use CupCakesBundle\Entity\Etape;
use CupCakesBundle\Entity\Ingredient;
use CupCakesBundle\Entity\Recette;
use CupCakesBundle\Entity\Vote;
use CupCakesBundle\Form\AjoutRecetteForm;
use CupCakesBundle\Form\RatingForm;
use CupCakesBundle\Form\RechercheRecetteForm;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RecetteController extends Controller
{
    public function recettesAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $recettes=$em->getRepository("CupCakesBundle:Recette")->findAll();

        $paginator  = $this->get('knp_paginator');

        $result = $paginator->paginate(
            $recettes,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3)
        );

        return $this->render('CupCakesBundle:Recette:recettes.html.twig',array("modeles"=>$result)) ;


    }

    public function AjoutAction(Request $request){
        $recette= new Recette() ;



        $Form=$this->createForm(AjoutRecetteForm::class,$recette) ;
        $Form->handleRequest($request);
        if ($Form->isValid() && $Form->isSubmitted())
        {
            dump($recette) ;

            $file=$recette->getImage() ;
            $fileName = md5(uniqid()).'.'.$file->guessExtension() ;
            $file->move($this->getParameter('image_directory'),$fileName) ;
            $recette->setImage($fileName) ;
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $recette->setUser($user) ;

            foreach ($recette->getEtapes() as $etape)
            {
                $etape->setRecette($recette) ;
            }
            foreach ($recette->getIngredients() as $ingredient)
            {
                $ingredient->setRecette($recette) ;
            }



            $em=$this->getDoctrine()->getManager();

            $em->persist($recette);



            $em->flush();
            return $this->redirectToRoute('recettes');
        }
        return $this->render('@CupCakes/Recette/ajoutRecette.html.twig' ,array('recette' => $recette,'Form'=>$Form->createView()));


    }

    public function showAction($id,Request $request)
    {

        $vote = new Vote() ;
        $Form = $this->createForm(RatingForm::class,$vote) ;
        $Form->handleRequest($request) ;
        $em=$this->getDoctrine()->getManager() ;



        $recette = $this->getDoctrine()
            ->getRepository('CupCakesBundle:Recette')
            ->find($id);
       $etapes=$em->getRepository("CupCakesBundle:Etape")->findEtapeDQL($id) ;
       $ingredients=$em->getRepository("CupCakesBundle:Ingredient")->findIngredientDQL($id) ;



        return $this->render('@CupCakes/Recette/recette.html.twig' ,array("form"=>$Form->createView(),"recette"=>$recette,'etapes'=>$etapes,'ingredients'=>$ingredients));

        // ... do something, like pass the $product object into a template
    }





    public function deleteAction($id){
        $em=$this->getDoctrine()->getManager() ;
        $modele=$em->getRepository("CupCakesBundle:Recette")->find($id);
        $etapes=$em->getRepository("CupCakesBundle:Etape")->findEtapeDQL($id) ;
        $ingredients=$em->getRepository("CupCakesBundle:Ingredient")->findIngredientDQL($id) ;

        $em->remove($modele);
        foreach ($etapes as $etape) {
            $em->remove($etape);
        }
        foreach ($ingredients as $ingredient) {
            $em->remove($ingredient);
        }

        $em->flush();
        return $this->redirectToRoute('recettes') ;

    }


    public function editAction($id, Request $request,Recette $recette)
    {
        $em = $this->getDoctrine()->getManager();
        $recette = $em->getRepository(Recette::class)->find($id);

        $originalEtapes = new ArrayCollection();

        foreach ($recette->getEtapes() as $etape) {
            $originalEtapes->add($etape);
        }

        $editForm = $this->createForm(AjoutRecetteForm::class, $recette);

        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()){

            $file=$recette->getImage() ;
            $fileName = md5(uniqid()).'.'.$file->guessExtension() ;
            $file->move($this->getParameter('image_directory'),$fileName) ;
            $recette->setImage($fileName) ;

            // remove the relationship between the tag and the Task
            foreach ($originalEtapes as $etape)  {
                if (false === $recette->getEtapes()->contains($etape)) {
                    // remove the Task from the Tag
                    $etape->getRecette()->removeElement($recette);

                    // if it was a many-to-one relationship, remove the relationship like this
                    // $tag->setTask(null);

                    $em->persist($etape);

                    // if you wanted to delete the Tag entirely, you can also do that
                    // $em->remove($tag);
                }
            }



            $em->persist($recette);
            $em->flush();


            // redirect back to some edit page
            return $this->redirectToRoute('recette_show', array('id' => $id));
    }
        return $this->render('@CupCakes/Recette/ajoutRecette.html.twig', array(
            'recette' => $recette,
            'Form' => $editForm->createView(),
        ));

    }

    public function rechercheAction(Request $request)  {
        $recette = new Recette() ;
        $em=$this->getDoctrine()->getManager();
        $Form=$this->createForm(RechercheRecetteForm::class,$recette);
        $Form->handleRequest($request);
        if($Form->isValid()) {
            $recette = $em->getRepository('CupCakesBundle:Recette')->findRecetteDQL($recette->getNom());
        }
        else{
            $recette=$em->getRepository("CupCakesBundle:Recette")->findAll();

        }

        return $this->render("@CupCakes/Recette/recherche.html.twig",['Form'=>$Form->createView(),'modeles'=>$recette]) ;

    }

    public function indexAction()
    {
        $em=$this->getDoctrine()->getManager();
        $recette=$em->getRepository("CupCakesBundle:Recette")->findAll();

        return $this->render('@CupCakes/Recette/index.html.twig',array("recettes"=>$recette)) ;
    }

    public function show2Action($id)
    {
        $em=$this->getDoctrine()->getManager() ;

        $recette = $this->getDoctrine()
            ->getRepository('CupCakesBundle:Recette')
            ->find($id);
        $etapes=$em->getRepository("CupCakesBundle:Etape")->findEtapeDQL($id) ;
        $ingredients=$em->getRepository("CupCakesBundle:Ingredient")->findIngredientDQL($id) ;


        return $this->render('@CupCakes/Recette/show.html.twig' ,array("recette"=>$recette,'etapes'=>$etapes,'ingredients'=>$ingredients));

        // ... do something, like pass the $product object into a template
    }
    public function delete3Action($id){
        $em=$this->getDoctrine()->getManager() ;
        $modele=$em->getRepository("CupCakesBundle:Recette")->find($id);
        $etapes=$em->getRepository("CupCakesBundle:Etape")->findEtapeDQL($id) ;
        $ingredients=$em->getRepository("CupCakesBundle:Ingredient")->findIngredientDQL($id) ;

        $em->remove($modele);
        foreach ($etapes as $etape) {
            $em->remove($etape);
        }
        foreach ($ingredients as $ingredient) {
            $em->remove($ingredient);
        }

        $em->flush();
        return $this->redirectToRoute('back_recette_index') ;

    }

    public function updateAction($id, Request $request,Recette $recette)
    {
        $em = $this->getDoctrine()->getManager();
        $recette = $em->getRepository(Recette::class)->find($id);

        $originalEtapes = new ArrayCollection();

        foreach ($recette->getEtapes() as $etape) {
            $originalEtapes->add($etape);
        }

        $editForm = $this->createForm(AjoutRecetteForm::class, $recette);

        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()){

            $file=$recette->getImage() ;
            $fileName = md5(uniqid()).'.'.$file->guessExtension() ;
            $file->move($this->getParameter('image_directory'),$fileName) ;
            $recette->setImage($fileName) ;

            // remove the relationship between the tag and the Task
            foreach ($originalEtapes as $etape)  {
                if (false === $recette->getEtapes()->contains($etape)) {
                    // remove the Task from the Tag
                    $etape->getRecette()->removeElement($recette);

                    // if it was a many-to-one relationship, remove the relationship like this
                    // $tag->setTask(null);

                    $em->persist($etape);

                    // if you wanted to delete the Tag entirely, you can also do that
                    // $em->remove($tag);
                }
            }



            $em->persist($recette);
            $em->flush();


            // redirect back to some edit page
            return $this->redirectToRoute('recette_show', array('id' => $id));
        }
        return $this->render('@CupCakes/Recette/update.html.twig', array(
            'recette' => $recette,
            'form' => $editForm->createView(),
        ));

    }

}
