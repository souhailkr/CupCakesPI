<?php
/**
 * Created by PhpStorm.
 * User: SouhaiKr
 * Date: 17/02/2018
 * Time: 18:14
 */

namespace CupCakesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="CupCakesBundle\Repository\EtapeRepository")
 */
class Etape
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    protected $id;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="CupCakesBundle\Entity\Recette", inversedBy="etapes")
     * @ORM\JoinColumn(name="recette_id", referencedColumnName="id")
     */
    protected $recette ;

    /**
     * @return mixed
     */


    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }





    /**
     * Set recette
     *
     * @param \CupCakesBundle\Entity\Recette $recette
     *
     * @return Etape
     */
    public function setRecette(\CupCakesBundle\Entity\Recette $recette = null)
    {
        $this->recette = $recette;

        return $this;
    }

    /**
     * Get recette
     *
     * @return \CupCakesBundle\Entity\Recette
     */
    public function getRecette()
    {
        return $this->recette;
    }
}
