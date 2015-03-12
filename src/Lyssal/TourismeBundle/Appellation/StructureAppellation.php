<?php
namespace Lyssal\TourismeBundle\Appellation;

use Lyssal\StructureBundle\Appellation\AppellationHandlerInterface;
use Lyssal\StructureBundle\Appellation\AppellationHandler;
use Lyssal\StructureBundle\Decorator\DecoratorManager;
use Symfony\Component\Routing\RouterInterface;
use Lyssal\TourismeBundle\Entity\Structure;
use Lyssal\TourismeBundle\Decorator\StructureDecorator;

class StructureAppellation extends AppellationHandler implements AppellationHandlerInterface
{
    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::supports()
     */
    public function supports($object)
    {
        return ($object instanceof Structure || $object instanceof StructureDecorator);
    }

    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::appellation()
     */
    public function appellation($structure)
    {
        return $structure->__toString();
    }

    /**
     * (non-PHPdoc)
     * @see \Lyssal\StructureBundle\Appellation\AppellationHandlerInterface::appellationHtml()
     */
    public function appellationHtml($structure)
    {
        return $this->appellation($structure);
    }
}
