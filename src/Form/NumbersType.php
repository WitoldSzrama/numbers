<?php

namespace App\Form;

use App\Entity\Numbers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class NumbersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('inputNumber',null, [
                'label' => 'Podaj liczbę przedstawiającą wielkość zbioru',
                'attr' => [
                    'min' => 1,
                    'max' => 99999,
                    'oninvalid'=>"setCustomValidity('Proszę podać numer z zakresu od 1 do 99999')"
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Zapisz',
                'attr' => [
                    'class' => 'btn btn-primary',
                    'required',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Numbers::class,
        ]);
    }
}
