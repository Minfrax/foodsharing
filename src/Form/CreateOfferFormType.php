<?php

namespace App\Form;


use App\Entity\Canton; // later for canton entity add
use App\Entity\Picture;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // later for canton entity add
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class CreateOfferFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('What you like to offer?', TextType::class, ['label' => 'FORM.OFFER.TITLE.LABEL'])
           ->add('Offer description', TextType::class, ['label' => 'FORM.OFFER.DESCRIPTION.LABEL'])
           ->add('Offer amount', TextType::class, ['label' => 'FORM.OFFER.QUANTITY.LABEL'])
           //->add('Select your Canton', EntityType::class, [
           //    'canton' => Canton::class,
           //    'choice label' => 'canton name'
           // ])
           ->add('file', FileType::class, [
               'label' => 'FORM.OFFER.PIC_FILE.LABEL',
               'mapped' => false,
               'constraints' => [new Image([
                   'mimeTypes' => ['image/png', 'image/jpeg'],
                   'maxSize' => '5M',
                   'minWidth' => 640,
                   'minHeight' => 640
               ])]
           ]
        );
        if ($options['standalone']) {
            $builder->add(
                'Submit',
                SubmitType::class,
                [
                    'label' => 'FORM.OFFER.SUBMIT.LABEL',
                    'attr' => [
                        'class' => 'btn-success'
                    ]
                ]

            );
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Picture::class,
            'standalone' => false
        ]);
    }


}