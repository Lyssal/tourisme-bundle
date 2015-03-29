<?php
namespace Lyssal\TourismeBundle\Decorator;

use Lyssal\StructureBundle\Decorator\DecoratorHandler;
use Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface;
use Lyssal\TourismeBundle\Entity\Caracteristique;

/**
 * Helper de Caracteristique..
 * 
 * @author Rémi Leclerc
 */
class CaracteristiqueDecorator extends DecoratorHandler implements DecoratorHandlerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Decorator\DecoratorHandlerInterface::supports()
     */
    public function supports($entity)
    {
        return ($entity instanceof Caracteristique);
    }


    /**
     * Retourne l'URL de l'icône 16px.
     *
     * @return string URL de l'icône
     */
    public function getIcone16Url()
    {
        return $this->router->getContext()->getBaseUrl().DIRECTORY_SEPARATOR.$this->entity->getIcone16Url();
    }
    
    /**
     * Retourne la balise HTML de l'icône 16px.
     * 
     * @return string Icône en HTML
     */
    public function getIcone16Html()
    {
        return '<img src="'.$this->getIcone16Url().'" alt="'.$this->entity->__toString().'" width="16" height="16">';
    }

    /**
     * Retourne l'URL de l'icône 32px.
     *
     * @return string URL de l'icône
     */
    public function getIcone32Url()
    {
        return $this->router->getContext()->getBaseUrl().DIRECTORY_SEPARATOR.$this->entity->getIcone32Url();
    }
    
    /**
     * Retourne la balise HTML de l'icône 32px.
     *
     * @return string Icône en HTML
     */
    public function getIcone32Html()
    {
        return '<img src="'.$this->getIcone32Url().'" alt="'.$this->entity->__toString().'" width="32" height="32">';
    }
}
