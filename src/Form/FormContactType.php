<?php

namespace App\Form;

use App\Entity\FormContact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Full Name',
                'attr' => [
                    'placeholder' => 'Enter your full name',
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email Address',
                'attr' => [
                    'placeholder' => 'your.email@example.com',
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('subject', TextType::class, [
                'label' => 'Subject',
                'attr' => [
                    'placeholder' => 'What is this about?',
                    'class' => 'form-control',
                ],
                'required' => false,
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'attr' => [
                    'placeholder' => 'Enter your message here...',
                    'class' => 'form-control',
                    'rows' => 5,
                ],
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormContact::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'contact_form',
        ]);
    }
}
