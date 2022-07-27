<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Article;
use App\Entity\Writer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label_attr' =>[
                    'class' => 'test-classe-label'
                ],
                'attr' => [
                    'class' => 'test-classe-input'
                ]
            ])
            ->add('body')
            ->add('published_at')
            ->add('tags', EntityType::class, ['class' => Tag::class, 
            'choice_label'=>'name', 
            'multiple' => true,
            'expanded' => true,
            'by_reference' =>false
            ])
            ->add('category', EntityType::class, ['class' => Category::class,
                 // looks for choices from this entity
                 
            
                 // uses the Category.name property as the visible option string
                 'choice_label' => function (Category $object) {
                     return "{$object->getName()} ({$object->getId()})";
                 },
             
                 // used to render a select box, check boxes or radios
                 // 'multiple' => true,
                 'expanded' => true,
                 'by_reference'=> false,

                 'query_builder' =>function (EntityRepository $er) {
                    return$er->createQueryBuilder('c')
                    ->ordebrBy();
                        
                 }
                 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }

}
