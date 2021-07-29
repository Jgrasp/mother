<?php

namespace App\Controller\Admin;

use App\Entity\ClientType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ClientTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ClientType::class;
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
