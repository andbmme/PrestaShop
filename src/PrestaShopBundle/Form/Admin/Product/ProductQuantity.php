<?php
/**
 * 2007-2015 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2015 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace PrestaShopBundle\Form\Admin\Product;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use PrestaShopBundle\Form\Admin\Product\ProductCombination;

/**
 * This form class is risponsible to generate the product quantity form
 */
class ProductQuantity extends AbstractType
{
    private $router;
    private $translator;
    private $container;

    /**
     * Constructor
     *
     * @param object $container The SF2 container
     */
    public function __construct($container)
    {
        $this->container = $container;
        $this->router = $container->get('router');
        $this->translator = $container->get('prestashop.adapter.translator');
    }

    /**
     * {@inheritdoc}
     *
     * Builds form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('attributes', 'text', array(
            'attr' =>  [
                'class' => 'tokenfield',
                'data-limit' => 20,
                'data-minLength' => 1,
                'placeholder' => $this->translator->trans('Type something...', [], 'AdminProducts'),
                'data-prefetch' => $this->router->generate('admin_attribute_get_all'),
                'data-action' => $this->router->generate('admin_attribute_generator'),
            ],
            'label' =>  $this->translator->trans('Create combinations', [], 'AdminProducts')
        ))
        ->add('combinations', 'collection', array(
            'type' => new ProductCombination($this->container),
            'allow_delete' => true
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'product_quantity';
    }
}
