<?php

namespace App\Controller\Admin;

use App\Admin\Field\OpenField;
use App\Admin\Field\PortField;
use App\Entity\Access;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AccessCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Access::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('project')
            ->setRequired(true)
            ->setQueryBuilder(function (QueryBuilder $builder) {
                return $builder
                    ->join('entity.client', 'client')
                    ->addOrderBy('client.name', 'ASC')
                    ->addOrderBy('entity.name', 'ASC');
            });

        yield TextField::new('host');
        yield AssociationField::new('environment')->setRequired(true);
        yield AssociationField::new('protocol')->setRequired(true);
        yield PortField::new('port');
        yield TextField::new('username');
        yield TextField::new('password');

        yield OpenField::new('Link')
            ->setVirtual(true)
            ->onlyOnIndex();
    }

}
