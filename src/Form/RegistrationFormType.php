<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter an email',
                    ]),
                    new Length([
                        'min' => 6,
                        'max' => 180,
                        'minMessage' => 'Your email should be at least {{ limit }} characters',
                        'maxMessage' => 'Your email should not be longer than {{ limit }} characters',
                    ]),
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'max' => 4096,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'maxMessage' => 'Your password should not be longer than {{ limit }} characters',
                    ]),
                ],
            ])
            ->add('name', TextType::class, [
                'label' => 'Name',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a name',
                    ]),
                    new Length([
                        'min' => 1,
                        'max' => 255,
                        'minMessage' => 'Your name should be at least {{ limit }} character',
                        'maxMessage' => 'Your name should not be longer than {{ limit }} characters',
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Last Name',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a last name',
                    ]),
                    new Length([
                        'min' => 1,
                        'max' => 255,
                        'minMessage' => 'Your last name should be at least {{ limit }} character',
                        'maxMessage' => 'Your last name should not be longer than {{ limit }} characters',
                    ]),
                ],
            ])
            ->add('telno', IntegerType::class, [
                'label' => 'Telephone Number',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a telephone number',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}