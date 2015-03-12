<?php
namespace Lyssal\TourismeBundle\Decorator;

use Lyssal\StructureBundle\Decorator\DecoratorHandler;
use Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface;
use Lyssal\TourismeBundle\Entity\Structure;

/**
 * Helper de Structure.
 * 
 * @author Rémi Leclerc
 */
class StructureDecorator extends DecoratorHandler implements DecoratorHandlerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface::supports()
     */
    public function supports($entity)
    {
        return ($entity instanceof Structure);
    }

    
    /**
     * Retourne les types de structure de la structure.
     * 
     * @return \Lyssal\TourismeBundle\Decorator\StructureTypeDecorator[] Types de structure (decorator)
     */
    public function getTypes()
    {
        return $this->decoratorManager->get($this->entity->getTypes());
    }
    
    /**
     * Retourne l'URL de l'icône 16px.
     * 
     * @return string URL de l'icône
     */
    public function getIcone16Url()
    {
        foreach ($this->getTypes() as $structureType)
            return $structureType->getIcone16Url();
        
        return null;
    }
}
