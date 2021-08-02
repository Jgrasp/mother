<?php

namespace App\Controller\Admin;

use App\Entity\Environment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EnvironmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Environment::class;
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
