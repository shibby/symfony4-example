<?php

namespace App\Form;

use App\Entity\CompanyForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Company Name',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('stocks', CollectionType::class, [
                'required' => true,
                'allow_add' => true,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create Company',
                'attr' => [
                    'class' => 'btn btn-success',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            //'data_class' => CompanyForm::class,
        ]);
    }
}
