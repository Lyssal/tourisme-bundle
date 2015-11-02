<?php
namespace Lyssal\TourismeBundle\Manager;

use Lyssal\StructureBundle\Manager\Manager;
use Lyssal\TourismeBundle\Entity\StructureType;

/**
 * Manager de l'entité Structure.
 * 
 * @author Rémi Leclerc
 */
class StructureManager extends Manager
{
    /**
     * Retourne les structures par type aux alentours de coordonnées géographiques.
     * 
     * @param \Lyssal\TourismeBundle\Entity\StructureType $structureType Type de structure
     * @param array<float, float> $coordonnees Coordonnées latitude + longitude
     * @param integer $distanceMaximale Distance maximale en mètres
     * @return array<\Lyssal\TourismeBundle\Entity\Structure, float> Structures avec leur distance
     */
    public function findByTypeAndCoordonnees(StructureType $structureType, array $coordonnees, $distanceMaximale)
    {
        return $this->getRepository()->findByTypeAndCoordonnees($structureType, $coordonnees, $distanceMaximale);
    }
}
