<?php

namespace App\Controller\Admin;

use App\Entity\PlaylistCancion;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class PlaylistCancionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PlaylistCancion::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('playlist','playlist')
            ->setFormTypeOption('by_reference',false),
            AssociationField::new('cancion','cancion')
            ->setFormTypeOption('by_reference',false),
            NumberField::new('reproducciones')
        ];
    }
   
}
