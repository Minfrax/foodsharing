<?php

namespace App\Form;

use App\Entity\Canton;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
// use's for termsAccepted //
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\IsTrue;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('username', TextType::class)

            // added to test proposes
            //->add('canton_id')
            ->add('email', EmailType::class)
            // end of added to test proposes

            ->add('password', RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'invalid_message' => 'Password must match',
                    'first_options' => ['label' => 'Password'],
                    'second_options' => ['label' =>'Repeat password']
                ])
            ->add('canton',
                EntityType::class,
                [
                    'label' => 'Canton',
                    'class' => Canton::class,
                    'multiple' => false
                ]
                )

            /// Adding a accept terms checkbox ///
            ->add(
                'termaccepted',
                CheckboxType::class, [
                'label' => 'Accept Terms of service'
            ]);
            if ($options['standalone']){
                $builder->add('Submit',SubmitType::class,
                    [
                        'label' => 'FORM.USER.SUBMIT.LABEL',
                        'attr' => ['class' =>'btn-success']
                    ])
                ;

            }
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'standalone' => false
        ]);
    }
}
