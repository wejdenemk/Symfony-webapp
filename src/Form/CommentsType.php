<?php

namespace App\Form;

use App\Entity\Comments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre e-mail',
                'attr' => [
                    'class' =>'form-control'
                ]
            ])
            ->add('nickname', TextType::class, [
                'label' => 'Sujet du pseudo', 
                'attr' => [
                    'class' =>'form-control'
                ]
            ])
            ->add('content', TextType::class, [
                'label' => 'votre commentaire', 
                'attr' => [
                    'class' =>'form-control'
                ]
            ])
            ->add('rgpd', CheckboxType::class)
            ->add('parent', TextType::class, [
                'label' => 'num de comment u wanna reply to ', 
                'attr' => [
                    'class' =>'form-control'
                ]
            ] )
            ->add('Envoyer', SubmitType::class, [ 
                'attr' => [
                    'class' =>'btn primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
