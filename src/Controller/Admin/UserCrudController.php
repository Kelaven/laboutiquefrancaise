<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            // IntegerField::new('id', 'ID'),
            TextField::new('firstname', 'Prénom'),
            TextField::new('lastname', 'Nom'),
            TextField::new('email', 'Email')->onlyOnIndex(), // onOnIndex pour ne pas pouvoir modifier le field mais l'avoir tout de même en vue
        ];
    }


}
