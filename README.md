# LyssalTourismeBundle

`LyssalTourismeBundle` contient différents outils facilitant le développement d'applications touristiques.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/1ec40011-a3eb-4292-beb5-13b313bf1318/small.png)](https://insight.sensiolabs.com/projects/1ec40011-a3eb-4292-beb5-13b313bf1318)


## Entités

Toutes les entités possèdent leur manager et leur gestion administrative (optionnelle) si vous utilisez `Sonata`.

Les entités sont :
* Structure : Une structure précise comme le musée du Louvre, l'hôtel des flots bleus, etc
* StructureType : Un type de structure comme musée, zoo, gare ferroviaire, office de tourisme, etc
* StructureGroupe : Un groupe de structure comme Carrefour, Krys, Devred, etc

Une structure peut appartenir à plusieurs types (par exemple hôtel et restaurant) mais ne peut appartenir qu'à un seul (ou aucun) groupe.


## Repository

Vous devez définir le `EntityRepository` de `StructureLyssalBundle` comme repository par défaut (ou définir pour chaque entité héritée d'un bundle Lyssal le repositoryClass).

Reportez-vous à la documentation de `StructureLyssalBundle` pour plus d'informations.


## Utilisation

Vous devez créer un bundle héritant `LyssalTourismeBundle` :

```php
namespace Acme\TourismeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AcmeTourismeBundle extends Bundle
{
    public function getParent()
    {
        return 'LyssalTourismeBundle';
    }
}
```

Ensuite, vous devez créer dans votre bundle les entités nécessaires héritant celles de `LyssalTourismeBundle`.

Vous devez hériter les entités ainsi :
```php
namespace Acme\TourismeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lyssal\TourismeBundle\Entity\Structure as BaseStructure;

/**
 * Structure.
 * 
 * @ORM\Entity
 * @ORM\Table(name="acme_structure", uniqueConstraints={@ORM\UniqueConstraint(name="SLUG_VILLE_UNIQUE", columns={"structure_slug", "ville_id"})})
 */
class Structure extends BaseStructure
{
    /**
     * @var \Acme\GeographieBundle\Entity\Ville
     * 
     * @ORM\ManyToOne(targetEntity="Acme\GeographieBundle\Entity\Ville", inversedBy="structures", cascade={"persist"})
     * @ORM\JoinColumn(name="ville_id", referencedColumnName="ville_id", nullable=false, onDelete="CASCADE")
     */
    protected $ville;

    /**
     * @var \Acme\TourismeBundle\Entity\StructureGroupe
     *
     * @ORM\ManyToOne(targetEntity="StructureGroupe", inversedBy="structures", cascade={"persist"})
     * @ORM\JoinColumn(name="structure_groupe_id", referencedColumnName="structure_groupe_id", nullable=true, onDelete="SET NULL")
     */
    protected $groupe;
    
    /**
     * @var \Acme\TourismeBundle\Entity\StructureType[]
     *
     * @ORM\ManyToMany(targetEntity="StructureType", inversedBy="structures", cascade="persist")
     * @ORM\JoinTable(name="acme_structure_a_structure_type", joinColumns={@ORM\JoinColumn(name="structure_id", referencedColumnName="structure_id", onDelete="CASCADE")}, inverseJoinColumns={@ORM\JoinColumn(name="structure_type_id", referencedColumnName="structure_type_id", onDelete="CASCADE")})
     */
    protected $types;
}
```
```php
namespace Acme\TourismeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lyssal\TourismeBundle\Entity\StructureGroupe as BaseStructureGroupe;

/**
 * Groupe de structure.
 * 
 * @ORM\Entity
 * @ORM\Table(name="acme_structure_groupe")
 */
class StructureGroupe extends BaseStructureGroupe
{
    /**
     * array
     *
     * @ORM\OneToMany(targetEntity="Structure", mappedBy="groupe", cascade={"persist"})
     */
    protected $structures;
}
```
```php
namespace Acme\TourismeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lyssal\TourismeBundle\Entity\StructureType as BaseStructureType;

/**
 * Type de structure.
 * 
 * @ORM\Entity
 * @ORM\Table(name="acme_structure_type")
 */
class StructureType extends BaseStructureType
{
    /**
     * @ORM\ManyToMany(targetEntity="Structure", mappedBy="types")
     */
    protected $structures;
}
```

Vous devez ensuite redéfinir les paramètres suivants :

* `lyssal.tourisme.entity.structure.class` : Acme\TourismeBundle\Entity\Structure

Exemple avec sur `Acme/GeographieBundle/Resources/config/services.xml` :

```xml
<?xml version="1.0" ?>
<container xmlns="http://symfony.com/schema/dic/services" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd">
    <parameters>
        <parameter key="lyssal.tourisme.entity.structure.class">Acme\TourismeBundle\Entity\Structure</parameter>
        <parameter key="lyssal.tourisme.entity.structure_groupe.class">Acme\TourismeBundle\Entity\StructureGroupe</parameter>
        <parameter key="lyssal.tourisme.entity.structure_type.class">Acme\TourismeBundle\Entity\StructureType</parameter>
    </parameters>
</container>
```

Vous devez également mettre à jour l'entité `Ville` de votre `AcmeGeographieBundle` (qui étend LyssalGeographieBundle) :

```php
namespace Acme\GeographieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lyssal\GeographieBundle\Entity\Ville as BaseVille;

/**
 * Ville.
 * 
 * @ORM\Entity
 * @ORM\Table(name="acme_ville")
 */
class Ville extends BaseVille
{
    //...
    
    /**
     * array
     *
     * @ORM\OneToMany(targetEntity="\Acme\TourismeBundle\Entity\Structure", mappedBy="ville", cascade={"persist"})
     */
    private $structures;

    
    /**
     * Add structures
     *
     * @param \Acme\TourismeBundle\Entity\Structure $structures
     * @return Ville
     */
    public function addStructure(\Acme\TourismeBundle\Entity\Structure $structures)
    {
        $this->structures[] = $structures;

        return $this;
    }

    /**
     * Remove structures
     *
     * @param \Acme\TourismeBundle\Entity\Structure $structures
     */
    public function removeStructure(\Acme\TourismeBundle\Entity\Structure $structures)
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
}
```


## Managers

Les services sont :
* `lyssal.tourisme.manager.structure`
* `lyssal.tourisme.manager.structure_groupe`
* `lyssal.tourisme.manager.structure_type`

### Exemple d'utilisation

Dans votre contrôleur :

```php
$tousLesStructureGroupes = $this->container->get('lyssal.tourisme.manager.structure_groupe')->findAll();
```

### Utiliser vos managers hérités de LyssalTourismeBundle

Si vous utilisez vos propres managers héritant des managers de `LyssalTourismeBundle`, vous pouvez redéfinir les paramètres suivants :
* `lyssal.tourisme.manager.structure.class`
* `lyssal.tourisme.manager.structure_groupe.class`
* `lyssal.tourisme.manager.structure_type.class`

Exemple en XML :
```xml
<parameters>
    <parameter key="lyssal.tourisme.manager.structure.class">Acme\TourismeBundle\Manager\StructureManager</parameter>
    <parameter key="lyssal.tourisme.manager.structure_groupe.class">Acme\TourismeBundle\Manager\StructureGroupeManager</parameter>
    <parameter key="lyssal.tourisme.manager.structure_type.class">Acme\TourismeBundle\Manager\StructureTypeManager</parameter>
</parameters>
```


## Vues

Certaines vues prédéfinies peuvent être incluses dans les vues de vos bundles.

### Ville

Liste de villes :
```twig
{% include 'LyssalTourismeBundle:Ville/include:list.html.twig' with { 'villes':villes } %}
```

Ville d'une liste :
```twig
{% include 'LyssalTourismeBundle:Ville/include:list_element.html.twig' with { 'ville':ville } %}
```

Affichage d'une ville :
```twig
{% include 'LyssalTourismeBundle:Ville/include:view.html.twig' with { 'ville':ville } %}
```

### Structure

Liste de structures :
```twig
{% include 'LyssalTourismeBundle:Structure/include:list.html.twig' with { 'structures':structures } %}
```

Structure d'une liste :
```twig
{% include 'LyssalTourismeBundle:Structure/include:list_element.html.twig' with { 'structure':structure } %}
```


## SonataAdmin

Les entités seront automatiquement intégrées à `SonataAdmin` si vous l'avez installé.

Si vous souhaitez redéfinir les classes `Admin`, il suffit de surcharger les paramètres suivants :
* `lyssal.tourisme.admin.structure.class`
* `lyssal.tourisme.admin.structure_groupe.class`
* `lyssal.tourisme.admin.structure_type.class`

Vous devriez également installer `IvoryCKEditorBundle` pour avoir automatiquement un éditeur graphique aux champs attendant du HTML.

Alternativement, vous pouvez juste installer `LyssalAdminBundle`.


## Installation

`LyssalTourismeBundle` utilise `LyssalGeographieBundle` que vous devrez également installer et paramétrer.
`LyssalTourismeBundle` utilise également `StofDoctrineExtensions` que vous devrez paramétrer pour les traductions (`gedmo_translatable`).

1. Mettez à jour votre `composer.json` :
```json
"require": {
    "lyssal/tourisme-bundle": "*"
}
```
2. Installez le bundle :
```sh
php composer.phar update
```
3. Mettez à jour `AppKernel.php` :
```php
new Lyssal\TourismeBundle\LyssalTourismeBundle(),
```
4. Créez les tables en base de données :
```sh
php app/console doctrine:schema:update --force
```
