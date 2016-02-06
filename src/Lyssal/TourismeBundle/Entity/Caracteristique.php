<?php
namespace Lyssal\TourismeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Sonata\TranslationBundle\Traits\Gedmo\PersonalTranslatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use Lyssal\StructureBundle\Traits\IconeTrait;
use Lyssal\Image;

/**
 * Caractéristique.
 * 
 * @author Rémi Leclerc
 * @ORM\MappedSuperclass
 */
abstract class Caracteristique implements TranslatableInterface
{
    use PersonalTranslatable;
    use IconeTrait;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="caracteristique_id", type="smallint", nullable=false, options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="caracteristique_nom", type="string", nullable=false, length=32)
     * @Assert\NotBlank
     * @Gedmo\Translatable
     */
    private $nom;

    /**
     * @var string
     * 
     * @ORM\Column(name="caracteristique_icone", type="string", length=64, nullable=false)
     */
    private $icone;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Lyssal\TourismeBundle\Entity\Structure", mappedBy="caracteristiques")
     */
    protected $structures;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->structures = new \Doctrine\Common\Collections\ArrayCollection();
    }
    

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
     * Set nom
     *
     * @param string $nom
     * @return Caracteristique
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set icone
     *
     * @param string $icone
     * @return Caracteristique
     */
    public function setIcone($icone)
    {
        $this->icone = $icone;

        return $this;
    }

    /**
     * Get icone
     *
     * @return string 
     */
    public function getIcone()
    {
        return $this->icone;
    }
    
    /**
     * Add structures
     *
     * @param \Lyssal\TourismeBundle\Entity\Structure $structures
     * @return Caracteristique
     */
    public function addStructure(\Lyssal\TourismeBundle\Entity\Structure $structures)
    {
        $this->structures[] = $structures;
    
        return $this;
    }
    
    /**
     * Remove structures
     *
     * @param \Lyssal\TourismeBundle\Entity\Structure $structures
     */
    public function removeStructure(\Lyssal\TourismeBundle\Entity\Structure $structures)
    {
        $this->structures->removeElement($structures);
    }
    
    /**
     * Get structures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStructures()
    {
        return $this->structures;
    }
    
    
    /**
     * Répertoire dans lequel est enregistré l'icône.
     *
     * @return string Dossier de l'icône
     */
    protected function getIconeUploadDir()
    {
        return 'img/lyssal_tourisme/caracteristique/32';
    }
    /**
     * Retourne l'URL de l'icône 32px.
     *
     * @return string URL de l'icône 32px
     */
    public function getIcone32Url()
    {
        return $this->getIconeChemin();
    }
    /**
     * Retourne l'URL de l'icône 16px.
     *
     * @return string URL de l'icône 16px
     */
    public function getIcone16Url()
    {
        return 'img/lyssal_tourisme/caracteristique/16/'.$this->icone;
    }
    /**
     * Enregistre l'icône sur le disque.
     *
     * @return void
     */
    protected function uploadIcone()
    {
        if (null !== $this->icone && file_exists($this->getIcone16Url()))
            unlink($this->getIcone16Url());
    
        $this->saveIcone(false);
    
        $icone = new Image($this->getIconeChemin());
        $icone->setNomMinifie($this->nom, '-', true, 64);
        $this->icone = $icone->getNom();
    
        $icone16 = $icone->copy($this->getIcone16Url(), false);
    
        $icone->redimensionne(32, 32);
        $icone16->redimensionne(16, 16);
    }
    
    
    /**
     * Retourne le nom de la caractéristique.
     *
     * @return string Nom
     */
    public function __toString()
    {
        return $this->nom;
    }
}
