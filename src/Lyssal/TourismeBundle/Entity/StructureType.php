<?php
namespace Lyssal\TourismeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Sonata\TranslationBundle\Traits\Gedmo\PersonalTranslatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Lyssal\StructureBundle\Traits\IconeTrait;
use Lyssal\Image;

/**
 * Type de structure.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass
 */
abstract class StructureType implements TranslatableInterface
{
    use PersonalTranslatable;
    use IconeTrait;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="structure_type_id", type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="structure_type_nom", type="string", nullable=false, length=64)
     * @Assert\NotBlank
     * @Gedmo\Translatable
     */
    private $nom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="structure_type_slug", length=64, unique=true)
     * @Gedmo\Slug(fields={"nom"}, style="camel", separator="_", updatable=true)
     */
    protected $slug;
    
    /**
     * @var \Lyssal\TourismeBundle\Entity\StructureType
     * 
     * @ORM\ManyToOne(targetEntity="StructureType", inversedBy="enfants", cascade={"persist"})
     * @ORM\JoinColumn(name="structure_type_parent_id", referencedColumnName="structure_type_id", nullable=true, onDelete="SET NULL")
     */
    protected $parent;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="structure_type_icone", type="string", length=64, nullable=false)
     */
    private $icone;
    
    /**
     * @var array<\Lyssal\GeographieBundle\Entity\StructureType>
     *
     * @ORM\OneToMany(targetEntity="StructureType", mappedBy="parent")
     */
    protected $enfants;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Lyssal\TourismeBundle\Entity\Structure", mappedBy="types")
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
     * @return StructureType
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
     * Set slug
     *
     * @param string $slug
     * @return StructureType
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }
    
    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set icone
     *
     * @param string $icone
     * @return StructureType
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
     * Set parent
     *
     * @param \Lyssal\TourismeBundle\Entity\StructureType $parent
     * @return StructureType
     */
    public function setParent(\Lyssal\TourismeBundle\Entity\StructureType $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Lyssal\TourismeBundle\Entity\StructureType 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add enfants
     *
     * @param \Lyssal\TourismeBundle\Entity\StructureType $enfants
     * @return StructureType
     */
    public function addEnfant(\Lyssal\TourismeBundle\Entity\StructureType $enfant)
    {
        $this->enfants[] = $enfant;
    
        return $this;
    }
    
    /**
     * Remove enfants
     *
     * @param \Lyssal\TourismeBundle\Entity\StructureType $enfants
     */
    public function removeEnfant(\Lyssal\TourismeBundle\Entity\StructureType $enfant)
    {
        $this->enfants->removeElement($enfant);
    }
    
    /**
     * Get enfants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnfants()
    {
        return $this->enfants;
    }

    /**
     * Add structures
     *
     * @param \Lyssal\TourismeBundle\Entity\Structure $structures
     * @return StructureType
     */
    public function addStructure(\Lyssal\TourismeBundle\Entity\Structure $structure)
    {
        $this->structures[] = $structure;

        return $this;
    }

    /**
     * Remove structures
     *
     * @param \Lyssal\TourismeBundle\Entity\Structure $structures
     */
    public function removeStructure(\Lyssal\TourismeBundle\Entity\Structure $structure)
    {
        $this->structures->removeElement($structure);
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
        return 'img/lyssal_tourisme/structure_type/32';
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
        return 'img/lyssal_tourisme/structure_type/16/'.$this->icone;
    }
    /**
     * Enregistre l'icône sur le disque.
     *
     * @return void
     */
    protected function uploadIcone()
    {
        // Si notre ancien icône 16px existe, on le supprime
        if (null !== $this->icone && file_exists($this->getIcone16Url()))
            unlink($this->getIcone16Url());
            
        // On enregistre la nouvelle icône
        $this->saveIcone(false);
        
        // On minifie le nom du fichier avec le nom de l'entité
        $icone = new Image($this->getIconeChemin());
        $icone->setNomMinifie($this->nom, '-', true, 64);
        $this->icone = $icone->getNom();
        
        // On copie l'icône pour le 16px
        $icone16 = $icone->copy($this->getIcone16Url(), false);

        // On redimensionne correctement nos icônes
        $icone->redimensionne(32, 32);
        $icone16->redimensionne(16, 16);
    }

    /**
     * ToString.
     *
     * @return toString
     */
    public function __toString()
    {
        return $this->nom;
    }
}
