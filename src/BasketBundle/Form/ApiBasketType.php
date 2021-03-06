<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Sonata\BasketBundle\Form;

use Metadata\MetadataFactoryInterface;

use Sonata\Component\Currency\CurrencyDataTransformer;
use Sonata\Component\Currency\CurrencyManagerInterface;
use Sonata\Component\Form\Transformer\SerializeDataTransformer;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ApiBasketType
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class ApiBasketType extends AbstractType
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var CurrencyManagerInterface
     */
    protected $currencyManager;

    /**
     * Constructor
     *
     * @param string                   $class           An entity data class
     * @param CurrencyManagerInterface $currencyManager A Sonata ecommerce currency manager
     */
    public function __construct($class, CurrencyManagerInterface $currencyManager)
    {
        $this->class           = $class;
        $this->currencyManager = $currencyManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $currencyTransformer = new CurrencyDataTransformer($this->currencyManager);

        $builder->add(
            $builder->create('currency', null)
                ->addModelTransformer($currencyTransformer)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => $this->class,
            'csrf_protection' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sonata_basket_api_form_basket';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'sonata_basket_api_form_basket_parent';
    }
}