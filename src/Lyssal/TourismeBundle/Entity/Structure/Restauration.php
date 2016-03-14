<?php
namespace Lyssal\TourismeBundle\Entity\Structure;

use Doctrine\ORM\Mapping as ORM;

/**
 * Structure\Restauration.
 * 
 * @author Rémi Leclerc
 * @ORM\MappedSuperclass
 */
abstract class Restauration
{
    /**
     * @var integer
     *
     * @ORM\Column(name="structure_restauration_id", type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Lyssal\TourismeBundle\Entity\Structure
     * 
     * @ORM\OneToOne(targetEntity="\Lyssal\TourismeBundle\Entity\Structure", mappedBy="restauration")
     */
    protected $structure;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="structure_restauration_nombre_etoiles", type="smallint", nullable=true, options={"unsigned":true})
     */
    private $nombreEtoiles;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="structure_restauration_nombre_places", type="smallint", nullable=true, options={"unsigned":true})
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
     * @return Restauration
     */
    public function setStructure(\Lyssal\TourismeBundle\Entity\Structure $structure = null)
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
     * @return Restauration
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
     * @return Restauration
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
     * Retourne le nom de la restauration.
     * 
     * @return string Nom
     */
    public function __toString()
    {
        return $this->structure->getNom();
    }
}
