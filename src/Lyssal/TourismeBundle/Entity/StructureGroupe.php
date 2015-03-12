<?php
namespace Lyssal\TourismeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Lyssal\StructureBundle\Entity\IconeTrait;
use Lyssal\Image;

/**
 * Type de structure.
 * 
 * @author Rémi Leclerc <rleclerc@Lyssal.com>
 * @ORM\MappedSuperclass
 */
abstract class StructureGroupe
{
    use IconeTrait;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="structure_groupe_id", type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="structure_groupe_nom", type="string", nullable=false, length=128)
     * @Assert\NotBlank
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="structure_groupe_slug", length=128, unique=true)
     * @Gedmo\Slug(fields={"nom"}, style="camel", separator="_", updatable=true)
     */
    protected $slug;

    /**
     * @var string
     * 
     * @ORM\Column(name="structure_groupe_icone", type="string", length=64, nullable=false)
     */
    private $icone;
    
    /**
     * array
     *
     * @ORM\OneToMany(targetEntity="\Lyssal\TourismeBundle\Entity\Structure", mappedBy="groupe", cascade={"persist"})
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
     * @return StructureGroupe
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
     * @return StructureGroupe
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
     * @return StructureGroupe
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
     * @return StructureGroupe
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
        return 'img/lyssal_tourisme/structure_groupe/32';
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
        return 'img/lyssal_tourisme/structure_groupe/16/'.$this->icone;
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
