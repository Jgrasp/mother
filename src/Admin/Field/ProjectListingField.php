<?php


namespace App\Admin\Field;


use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

final class ProjectListingField implements FieldInterface
{
    use FieldTrait;

    const PROJECTS_URL = 'projectsUrl';

    public static function new(string $propertyName, ?string $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplatePath('admin/field/project_listing.html.twig')
            ->setFormType(UrlType::class)
            ->addCssClass('field-url');
   }

}