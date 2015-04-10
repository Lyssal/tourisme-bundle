<?php
namespace Lyssal\TourismeBundle\Entity\Structure;

use Doctrine\ORM\Mapping as ORM;

/**
 * Structure\Hebergement.
 * 
 * @author Rémi Leclerc
 * @ORM\MappedSuperclass
 */
abstract class Hebergement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="structure_hebergement_id", type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Lyssal\TourismeBundle\Entity\Structure
     * 
     * @ORM\OneToOne(targetEntity="\Lyssal\TourismeBundle\Entity\Structure", mappedBy="hebergement")
     */
    protected $structure;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="structure_hebergement_nombre_etoiles", type="smallint", nullable=true, options={"unsigned":true})
     */
    private $nombreEtoiles;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="structure_hebergement_nombre_places", type="smallint", nullable=true, options={"unsigned":true})
     */
    private $nombrePlaces;

    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set structure
     *
     * @param \Lyssal\TourismeBundle\Entity\Structure $structure
     * @return Hebergement
     */
    public function setStructure(\LaVendee\TourismeBundle\Entity\Structure $structure = null)
    {
        $this->structure = $structure;

        return $this;
    }
    
    /**
     * Get structure
     *
     * @return \Lyssal\TourismeBundle\Entity\Structure
     */
    public function getStructure()
    {
        return $this->structure;
    }

    /**
     * Set nombreEtoiles
     *
     * @param integer $nombreEtoiles
     * @return Hebergement
     */
    public function setNombreEtoiles($nombreEtoiles)
    {
        $this->nombreEtoiles = $nombreEtoiles;

        return $this;
    }

    /**
     * Get nombreEtoiles
     *
     * @return integer 
     */
    public function getNombreEtoiles()
    {
        return $this->nombreEtoiles;
    }

    /**
     * Set nombrePlaces
     *
     * @param integer $nombrePlaces
     * @return Hebergement
     */
    public function setNombrePlaces($nombrePlaces)
    {
        $this->nombrePlaces = $nombrePlaces;

        return $this;
    }

    /**
     * Get nombrePlaces
     *
     * @return integer 
     */
    public function getNombrePlaces()
    {
        return $this->nombrePlaces;
    }
    
    
    /**
     * Retourne le nom de l'hébergement.
     * 
     * @return string Nom
     */
    public function __toString()
    {
        return $this->structure->getNom();
    }
}
