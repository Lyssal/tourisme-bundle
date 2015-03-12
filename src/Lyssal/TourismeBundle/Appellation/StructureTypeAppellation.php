<?php
namespace Lyssal\TourismeBundle\Appellation;

use Lyssal\StructureBundle\Appellation\AppellationHandlerInterface;
use Lyssal\StructureBundle\Appellation\AppellationHandler;
use Lyssal\StructureBundle\Decorator\DecoratorManager;
use Symfony\Component\Routing\RouterInterface;
use Lyssal\TourismeBundle\Entity\StructureType;
use Lyssal\TourismeBundle\Decorator\StructureTypeDecorator;

class StructureTypeAppellation extends AppellationHandler implements AppellationHandlerInterface
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
        return ($object instanceof StructureType || $object instanceof StructureTypeDecorator);
    }

    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::appellation()
     */
    public function appellation($structureType)
    {
        return $structureType->__toString();
    }

    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::appellationHtml()
     */
    public function appellationHtml($structureType)
    {
        if ($structureType instanceof StructureTypeDecorator)
            return $structureType->getIcone16Html().' '.$this->appellation($structureType->getEntity());
        else return $this->decoratorManager->get($structureType)->getIcone16Html().' '.$this->appellation($structureType);
    }
}
