<?php

namespace App\Form;

use App\Entity\Pays;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends AbstractType
{

          /**
     * @param string $label
     * @param string $placeholder
     * @return array
     */
   public function getConfiguration($label, $placeholder){
    return [
        'label'=>$label,
        'attr' => [
            'placeholder'=>$placeholder
        ]
        ];
}  

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('username',TextType::class, $this->getConfiguration(" Prenom","Veillez saisir votre prenom "))
        ->add('email',EmailType::class, $this->getConfiguration(" Email","Veillez saisir votre adresse email"))
        ->add('password',PasswordType::class , $this->getConfiguration(" Mot de passe ","Veillez saisir votre mot de passe "))
        ->add('confirm_password',PasswordType::class , $this->getConfiguration(" Confirmation du mot de passe","Veillez  confirmé votre mot de passe  "))
        ->add('imageFile',VichImageType::class,[
            'required' => false,
            'allow_delete' =>true,
            'download_uri' =>false,
        ])
        ->add('userSelect',EntityType::class, [
            'class'=> Pays::class
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
