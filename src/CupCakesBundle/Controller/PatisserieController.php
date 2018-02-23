<?php

namespace CupCakesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PatisserieController extends Controller
{
    public function indexAction()
    {
        return $this->render('CupCakesBundle:Patisserie:patisseries.html.twig');

    }
}
