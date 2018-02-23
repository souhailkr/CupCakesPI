<?php

namespace CupCakesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AstuceController extends Controller
{
    public function indexAction()
    {
        return $this->render('CupCakesBundle:Astuce:astuces.html.twig');

    }
}
