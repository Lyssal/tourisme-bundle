<?php
namespace Lyssal\TourismeBundle\Appellation;

use Lyssal\StructureBundle\Appellation\AppellationHandlerInterface;
use Lyssal\StructureBundle\Appellation\AppellationHandler;
use Lyssal\StructureBundle\Decorator\DecoratorManager;
use Symfony\Component\Routing\RouterInterface;
use Lyssal\TourismeBundle\Entity\Caracteristique;
use Lyssal\TourismeBundle\Decorator\CaracteristiqueDecorator;

class CaracteristiqueAppellation extends AppellationHandler implements AppellationHandlerInterface
{
    /**
     * @var \Lyssal\StructureBundle\Decorator\DecoratorManager DecoratorManager
     */
    private $decoratorManager;
    
    /**
     * Constructeur de AppellationManager.
     * 
     * @param \Lyssal\StructureBundle\Decorator\DecoratorManager $decoratorManager DecoratorManager
     */
    public function __construct(RouterInterface $router, DecoratorManager $decoratorManager)
    {
        parent::__construct($router);
        
        $this->decoratorManager = $decoratorManager;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::supports()
     */
    public function supports($object)
    {
        return ($object instanceof Caracteristique || $object instanceof CaracteristiqueDecorator);
    }

    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::appellation()
     */
    public function appellation($caracteristique)
    {
        return $caracteristique->__toString();
    }

    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::appellationHtml()
     */
    public function appellationHtml($caracteristique)
    {
        if ($caracteristique instanceof CaracteristiqueDecorator)
            return $caracteristique->getIcone16Html().' '.$this->appellation($caracteristique->getEntity());
        else return $this->decoratorManager->get($caracteristique)->getIcone16Html().' '.$this->appellation($caracteristique);
    }
}
