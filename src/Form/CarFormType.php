<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\CarTypes;
use App\Entity\Manufacturer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CarFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name')
            ->add('Price')
            ->add('Description', TextareaType::class, [
                'attr' => [
                    'style' => 'min-height: 200px;'
                ]
            ])
            ->add('Amount')

            ->add('Manufacturer', EntityType::class,
            [
                'class' => Manufacturer::class,
                'choice_label' => 'Name',
                'multiple' => false,
                'expanded' => false
            ])

            ->add('CarType', EntityType::class,
            [
                'class' => CarTypes::class,
                'choice_label' => 'Name', 
                'multiple' => false,
                'expanded' => false
            ])
          
            ->add('YearOfManufacture', DateType::class,
            [
                'widget' => 'single_text' 
            ])
   
            ->add('ImageFile', FileType::class, [
                'mapped' => false,
                'required' => false, 
            
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/*' 
                        ],
                        'mimeTypesMessage' => 'Only accept image',
                    ])
                ],
                'attr' => [
                    'accept' => 'image/*' 
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
