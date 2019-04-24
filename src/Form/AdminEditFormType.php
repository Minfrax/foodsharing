<?php


namespace App\Form;


use App\Entity\Canton;
use App\Entity\Offer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class AdminEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'FORM.OFFER.TITLE.LABEL'])
            ->add('description', TextareaType::class, ['label' => 'FORM.OFFER.DESCRIPTION.LABEL'])
            ->add('canton_id', EntityType::class,
                [
                    'label' => 'FORM.OFFER.CANTON.LABEL',
                    'class' => Canton::class,
                    'required' => true,
                ])
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
            'data_class' => Offer::class,
            'standalone' => false
        ]);
    }



}