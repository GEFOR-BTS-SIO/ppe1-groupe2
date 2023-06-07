<?php

namespace App\Form;

use App\Entity\Eleve;
use App\Entity\Formation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Validator\Constraints\File;

class EleveType extends AbstractType

{


    private $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $isAdmin = $this->authorizationChecker->isGranted('ROLE_ADMIN');

        $builder
            ->add('email', null, [
                'attr' => [
                    'class' => 'bg-blue-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5',
                ],
            ]);

            
            if ($isAdmin) {
                $builder->add('roles', ChoiceType::class, [
                    'choices'  => [
                        'User' => 'ROLE_USER',
                        'Admin' => 'ROLE_ADMIN',
                    ],
                    'multiple' => true,
                    'expanded' => true,
                    'attr' => [
                        'class' => 'text-blue-600',
                    ],
                ]);
            }

            $builder
            ->add('password', PasswordType::class,  [
                'attr' => [
                    'class' => 'bg-blue-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5',
                ],
                'empty_data' => '',
            ])
            ->add('name', null, [
                'attr' =>[
                    'class' => 'bg-blue-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5',
                ],
            ])
            ->add('firstname', null, [
                'attr' => [
                    'class' => 'bg-blue-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5',
                ],
            ])
            ->add('idCursus', EntityType::class, [
                'class' => Formation::class,
                'choice_label' => 'cursus',
                'attr' => [
                    'class' => 'bg-blue-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5',
                ],
            ])
            
            ->add('photo', FileType::class, [
                'label' => 'Image de profil (jpeg or png)',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'text-blue-600',
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
        ]);
    }
}
