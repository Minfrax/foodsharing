<?php
/**
 * Created by PhpStorm.
 * User: Student
 * Date: 17/04/2019
 * Time: 12:25
 */

namespace App\Form;

use App\Entity\Canton;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('username', TextType::class)
            ->add('email', EmailType::class)
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