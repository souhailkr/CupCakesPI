<?php

namespace CupCakesBundle\Controller;

use CupCakesBundle\CupCakesBundle;
use CupCakesBundle\Entity\Recette;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{


    public function indexAction()
    {
        return $this->render('CupCakesBundle:Default:index.html.twig');
    }
    public function dashboardAction()
    {
        return $this->render('CupCakesBundle:Default:dashboard.html.twig');
    }





}
