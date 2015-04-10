<?php
namespace Lyssal\TourismeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Sonata\TranslationBundle\Traits\Gedmo\PersonalTranslatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Structure.
 * 
 * @author Rémi Leclerc
 * @ORM\MappedSuperclass()
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Structure implements TranslatableInterface
{
    use PersonalTranslatable;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="structure_id", type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="structure_nom", type="string", nullable=false, length=128)
     * @Assert\NotBlank
     * @Gedmo\Translatable
     */
    private $nom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="structure_slug", length=128, unique=true)
     * @Gedmo\Slug(fields={"nom"}, style="camel", separator="_", updatable=true)
     */
    protected $slug;
    
    /**
     * @var string
     *
     * @ORM\Column(name="structure_description", type="string", nullable=false, length=255)
     * @Assert\NotBlank
     * @Gedmo\Translatable
     */
    private $description;
    
    /**
     * @var \Lyssal\TourismeBundle\Entity\StructureGroupe
     * 
     * @ORM\ManyToOne(targetEntity="StructureGroupe", inversedBy="structures", cascade={"persist"})
     * @ORM\JoinColumn(name="structure_groupe_id", referencedColumnName="structure_groupe_id", nullable=true, onDelete="SET NULL")
     */
    protected $groupe;
    
    /**
     * @var \Lyssal\GeographieBundle\Entity\Ville
     * 
     * @ORM\ManyToOne(targetEntity="Ville", inversedBy="structures", cascade={"persist"})
     * @ORM\JoinColumn(name="ville_id", referencedColumnName="ville_id", nullable=false, onDelete="CASCADE")
     */
    protected $ville;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="structure_adresse", type="string", nullable=true, length=255)
     */
    private $adresse;
    
    /**
     * @var number
     *
     * @ORM\Column(name="structure_latitude", type="decimal", nullable=true, precision=10, scale=8)
     */
    private $latitude;
    
    /**
     * @var number
     *
     * @ORM\Column(name="structure_longitude", type="decimal", nullable=true, precision=10, scale=8)
     */
    private $longitude;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="structure_site_web", type="string", nullable=true, length=64)
     */
    private $siteWeb;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="structure_telephone", type="string", nullable=true, length=16)
     */
    private $telephone;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="structure_horaires", type="string", nullable=true, length=512)
     * @Gedmo\Translatable
     */
    private $horaires;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="structure_tarifs", type="string", nullable=true, length=512)
     * @Gedmo\Translatable
     */
    private $tarifs;
    
    /**
     * @var string
     *
     * @ORM\Column(name="structure_contenu", type="text", nullable=true)
     * @Gedmo\Translatable
     */
    private $contenu;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="structure_observations", type="string", nullable=true, length=1024)
     * @Gedmo\Translatable
     */
    private $observations;
    
    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="structure_derniere_modification", type="datetime", nullable=false)
     */
    private $derniereModification;
    
    /**
     * @var \Lyssal\TourismeBundle\Entity\StructureType[]
     *
     * @ORM\ManyToMany(targetEntity="StructureType", inversedBy="structures", cascade="persist")
     * @ORM\JoinTable(name="lyssal_structure_a_structure_type", joinColumns={@ORM\JoinColumn(name="structure_id", referencedColumnName="structure_id")}, inverseJoinColumns={@ORM\JoinColumn(name="structure_type_id", referencedColumnName="structure_type_id")})
     */
    protected $types;
    
    /**
     * @var \Lyssal\TourismeBundle\Entity\Caracteristique[]
     *
     * @ORM\ManyToMany(targetEntity="Caracteristique", inversedBy="structures", cascade="persist")
     * @ORM\JoinTable(name="lyssal_structure_a_caracteristique", joinColumns={@ORM\JoinColumn(name="structure_id", referencedColumnName="structure_id")}, inverseJoinColumns={@ORM\JoinColumn(name="caracteristique_id", referencedColumnName="caracteristique_id")})
     */
    protected $caracteristiques;

    /**
     * @var \Lyssal\TourismeBundle\Entity\Structure\Hebergement
     *
     * @ORM\OneToOne(targetEntity="\Lyssal\TourismeBundle\Entity\Structure\Hebergement", inversedBy="structure", cascade="persist", fetch="EAGER")
     * @ORM\JoinColumn(name="structure_hebergement_id", referencedColumnName="structure_hebergement_id", nullable=true, onDelete="CASCADE")
     */
    protected $hebergement;

    /**
     * @var \Lyssal\TourismeBundle\Entity\Structure\Restauration
     *
     * @ORM\OneToOne(targetEntity="\Lyssal\TourismeBundle\Entity\Structure\Restauration", inversedBy="structure", cascade="persist", fetch="EAGER")
     * @ORM\JoinColumn(name="structure_restauration_id", referencedColumnName="structure_restauration_id", nullable=true, onDelete="CASCADE")
     */
    protected $restauration;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->types = new \Doctrine\Common\Collections\ArrayCollection();
        $this->caracteristiques = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Structure
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
     * @return Structure
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
     * Set description
     *
     * @param string $description
     * @return Structure
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set groupe
     *
     * @param \Lyssal\TourismeBundle\Entity\StructureGroupe $groupe
     * @return Structure
     */
    public function setGroupe(\Lyssal\TourismeBundle\Entity\StructureGroupe $groupe = null)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return \Lyssal\TourismeBundle\Entity\StructureGroupe 
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * Set ville
     *
     * @param \Lyssal\GeographieBundle\Entity\Ville $ville
     * @return Structure
     */
    public function setVille(\Lyssal\GeographieBundle\Entity\Ville $ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return \Lyssal\GeographieBundle\Entity\Ville 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Structure
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Structure
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Structure
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set siteWeb
     *
     * @param string $siteWeb
     * @return Structure
     */
    public function setSiteWeb($siteWeb)
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    /**
     * Get siteWeb
     *
     * @return string 
     */
    public function getSiteWeb()
    {
        return $this->siteWeb;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return Structure
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set horaires
     *
     * @param string $horaires
     * @return Structure
     */
    public function setHoraires($horaires)
    {
        $this->horaires = $horaires;

        return $this;
    }

    /**
     * Get horaires
     *
     * @return string 
     */
    public function getHoraires()
    {
        return $this->horaires;
    }

    /**
     * Set tarifs
     *
     * @param string $tarifs
     * @return Structure
     */
    public function setTarifs($tarifs)
    {
        $this->tarifs = $tarifs;

        return $this;
    }

    /**
     * Get tarifs
     *
     * @return string 
     */
    public function getTarifs()
    {
        return $this->tarifs;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Structure
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set observations
     *
     * @param string $observations
     * @return Structure
     */
    public function setObservations($observations)
    {
        $this->observations = $observations;

        return $this;
    }

    /**
     * Get observations
     *
     * @return string 
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * Set derniereModification
     *
     * @param \DateTime $derniereModification
     * @return Structure
     */
    public function setDerniereModification($derniereModification)
    {
        $this->derniereModification = $derniereModification;

        return $this;
    }

    /**
     * Get derniereModification
     *
     * @return \DateTime 
     */
    public function getDerniereModification()
    {
        return $this->derniereModification;
    }

    /**
     * Add types
     *
     * @param \Lyssal\TourismeBundle\Entity\StructureType $types
     * @return Structure
     */
    public function addType(\Lyssal\TourismeBundle\Entity\StructureType $type)
    {
        $this->types[] = $type;

        return $this;
    }

    /**
     * Remove types
     *
     * @param \Lyssal\TourismeBundle\Entity\StructureType $types
     */
    public function removeType(\Lyssal\TourismeBundle\Entity\StructureType $type)
    {
        $this->types->removeElement($type);
    }

    /**
     * Get types
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTypes()
    {
        return $this->types;
    }
    
    /**
     * Add caracteristiques
     *
     * @param \Lyssal\TourismeBundle\Entity\Caracteristique $caracteristiques
     * @return Structure
     */
    public function addCaracteristique(\Lyssal\TourismeBundle\Entity\Caracteristique $caracteristiques)
    {
        $this->caracteristiques[] = $caracteristiques;
    
        return $this;
    }
    
    /**
     * Remove caracteristiques
     *
     * @param \Lyssal\TourismeBundle\Entity\Caracteristique $caracteristiques
     */
    public function removeCaracteristique(\Lyssal\TourismeBundle\Entity\Caracteristique $caracteristiques)
    {
        $this->caracteristiques->removeElement($caracteristiques);
    }
    
    /**
     * Get caracteristiques
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCaracteristiques()
    {
        return $this->caracteristiques;
    }
    
    /**
     * Set hebergement
     *
     * @param \Lyssal\TourismeBundle\Entity\Structure\Hebergement $hebergement
     * @return Structure
     */
    public function setHebergement(\Lyssal\TourismeBundle\Entity\Structure\Hebergement $hebergement = null)
    {
        $this->hebergement = $hebergement;

        return $this;
    }
    
    /**
     * Get hebergement
     *
     * @return \Lyssal\TourismeBundle\Entity\Structure\Hebergement
     */
    public function getHebergement()
    {
        return $this->hebergement;
    }
    
    /**
     * Set restauration
     *
     * @param \Lyssal\TourismeBundle\Entity\Structure\Restauration $restauration
     * @return Structure
     */
    public function setRestauration(\Lyssal\TourismeBundle\Entity\Structure\Restauration $restauration = null)
    {
        $this->restauration = $restauration;
    
        return $this;
    }
    
    /**
     * Get restauration
     *
     * @return \Lyssal\TourismeBundle\Entity\Structure\Restauration
     */
    public function getRestauration()
    {
        return $this->restauration;
    }
    
    
    /**
     * Retourne le nom de la structure.
     * 
     * @return string Nom
     */
    public function __toString()
    {
        return $this->nom;
    }

    /**
     * Traitement à la création.
     * 
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->preUpdate();
    }
    
    /**
     * Traitement à la modification.
     * 
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->derniereModification = new \DateTime();
    }
}
