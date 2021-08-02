<?php

namespace App\Controller\Admin;

use App\Entity\AccessType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AccessTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AccessType::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
