<?php

namespace App\Form;

use App\Entity\Pays;
use App\Entity\Categorie;
use App\Entity\Continent;
use App\Entity\Catastrophe;
use App\Entity\Souscategorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CatastropheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('localisation',TextType::class)
        ->add('description',TextareaType::class)
        ->add('nombreMort',IntegerType::class)
        ->add('nombreBlesses',IntegerType::class)
        ->add('ville',TextType::class)
        ->add('nomCatastrophe',TextType::class)
        ->add('autresVictimes',IntegerType::class)
        ->add('sansAbris',IntegerType::class)
        ->add('dimension',NumberType::class)
        ->add('causeCatastrophe',TextType::class)
        ->add('continent',EntityType::class, [
            'class'=> Continent::class
        ])
        ->add('categorie',EntityType::class, [
            'class'=> Categorie::class
        ])
        ->add('souscategorie',EntityType::class, [
            'class'=> Souscategorie::class
        ])
        ->add('pays',EntityType::class, [
            'class'=> Pays::class
        ])
        ->add('images', FileType::class,[
            'label' => false,
            'multiple' => true,
            'mapped' => false,
            'required' => false
        ])
    
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Catastrophe::class,
        ]);
    }
}
