<?php

namespace Asma\RecaptchaBundle\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormInterface as FormFormInterface;
use Symfony\Component\Form\FormView;
 
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecaptchaSubmitType extends AbstractType
{
 
    public function __construct(string $key){
        $this->key=$key;
    }
    
        
     
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'mapped' => false,
             
        ]);
    }

public function buildView(FormView $view, FormFormInterface $form, array $options)
{
    $view->vars['label']=false;
    $view->vars['key']= $this->key;
    $view->vars['button']=$options['label'];
}

    public function getBlockPrefix()
    {
        return 'recaptcha_submit';
    }

    public function getParent()
    {
        return TypeTextType::class;
    }
}