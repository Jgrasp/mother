<?php

namespace App\Controller\Admin;

use App\Entity\Protocol;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProtocolCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Protocol::class;
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
