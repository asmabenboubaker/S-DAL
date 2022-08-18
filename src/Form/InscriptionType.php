<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Asma\RecaptchaBundle\Type\RecaptchaSubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login')
            ->add('email')
            ->add('mdp', PasswordType::class )
            ->add('nom')
            ->add('prenom')
          ->add('captcha', RecaptchaSubmitType::class,
          ['label'=>'Envoyer']
          )
            ->add('genre', ChoiceType::class,[
                'choices' => [
                    'homme' => 'homme',
                    'femme' => 'femme',

                ],
                'expanded' => true
            ])






        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
