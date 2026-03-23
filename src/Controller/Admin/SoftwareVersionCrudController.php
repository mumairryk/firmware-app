<?php

namespace App\Controller\Admin;

use App\Entity\SoftwareVersion;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class SoftwareVersionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SoftwareVersion::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('system_version'),
            TextField::new('system_version_alt'),
            UrlField::new('link'),
            TextField::new('st'),
            TextField::new('gd'),
            BooleanField::new('latest'),
            BooleanField::new('is_lci'),
            TextField::new('lci_type'),
        ];
    }
}
