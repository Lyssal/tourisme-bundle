<?php
namespace Lyssal\TourismeBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Classe StructureAdmin pour SonataAdmin.
 * 
 * @author Rémi Leclerc
 */
class StructureAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nom')
            ->add('groupe')
            ->add('types')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nom')
            ->add('ville')
            ->add('types')
            ->add('derniereModification')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nom')
            ->add('description')
            ->add
            (
				'ville',
				'sonata_type_model_autocomplete',
				array
				(
					'property'=>'nom',
					'attr' => array('style' => 'width:100%;'),
					'to_string_callback' => function($entity, $property) { return $entity->getNom().' ('.$entity->getCodePostal().')'; }
				)
			)
            ->add('latitude', 'text', array('required' => false))
            ->add('longitude', 'text', array('required' => false))
            ->add('groupe')
            ->add('types')
            ->add('caracteristiques')
            ->add
            (
                'adresse',
                'textarea',
                array
                (
                    'required' => false
                )
            )
            ->add('siteWeb')
            ->add('telephone')
            ->add
            (
                'horaires',
                'textarea',
                array
                (
                    'required' => false
                )
            )
            ->add
            (
                'tarifs',
                'textarea',
                array
                (
                    'required' => false
                )
            )
            ->add
            (
                'observations',
                'textarea',
                array
                (
                    'required' => false
                )
            )
        ;
        if ($this->getConfigurationPool()->getContainer()->get('form.registry')->hasType('ckeditor'))
        {
            $formMapper
                ->add
                (
                    'contenu',
                    'ckeditor',
                    array
                    (
                        'required' => false,
                        'config_name' => 'basic'
                    )
                )
            ;
        }
        else
        {
            $formMapper
                ->add
                (
                    'contenu',
                    'textarea',
                    array
                    (
                        'required' => false
                    )
                )
            ;
        }

        if (null !== $this->getSubject()->getHebergement())
        {
            $formMapper
                ->add
                (
                    'hebergement',
                    'sonata_type_admin',
                    array('btn_add' => false, 'btn_delete' => false)
                )
            ;
        }

        if (null !== $this->getSubject()->getRestauration())
        {
            $formMapper
                ->add
                (
                    'restauration',
                    'sonata_type_admin',
                    array('btn_add' => false, 'btn_delete' => false)
                )
            ;
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('nom')
            ->add('description')
            ->add('ville')
            ->add('latitude')
            ->add('longitude')
            ->add('groupe')
            ->add('types')
            ->add('caracteristiques')
            ->add('adresse')
            ->add('siteWeb')
            ->add('telephone')
            ->add('horaires')
            ->add('tarifs')
            ->add('observations')
            ->add('contenu')
            ->add('derniereModification')
        ;
    }
}
