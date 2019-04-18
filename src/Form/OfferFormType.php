<?php
/**
 * Created by PhpStorm.
 * User: Student
 * Date: 18/04/2019
 * Time: 10:01
 */

namespace App\Form;

use App\Entity\Offer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Image;

class OfferFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, ['label' => 'FORM.OFFER.TITLE.LABEL'])
            ->add(
                'description',
                TextareaType::class,
                ['label' => 'FORM.OFFER.DESCRIPTION.LABEL', 'required' => false]
            )
            ->add(
                'picture_path',
                FileType::class,
                [
                    'label' => 'FORM.OFFER.PICTURE_PATH.LABEL',
                    'mapped' => false,
                    'constraints' => [
                        new Image([
                            'mimeTypes' => ['images/png', 'image/jpeg'],
                            'maxSize' => '5M',
                            'minHeight' => 640,
                            'minWidth' => 640
                        ])
                    ]
                ]
            );

        if($options['standalone'])
        {
            $builder->add(
                'Submit',
                SubmitType::class,
                [
                    'label' => 'FORM.OFFER.SUBMIT.LABEL',
                    'attr' => ['class' => 'btn-success']
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


    /**
     * @Route("/picture/{offer}", name="get_picture_content")
     * @return Response
     */
    public function gimmePic(Offer $offer)
    {
        $path = $this->getParameter('upload_directory') . $offer->getPicturePath();

        return new Response(
            file_get_contents($path),
            200,
            [
                'Content-Type' => $offer->getMimeType()
            ]
        );
    }


}