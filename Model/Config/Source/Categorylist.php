<?php

namespace Dispatch\SalesChannel\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

/**
 * Categorylist source model for category configuration options.
 */
class CategoryList implements ArrayInterface
{
    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var CollectionFactory
     */
    protected $categoryCollectionFactory;

    /**
     * CategoryList constructor.
     *
     * @param CategoryFactory $categoryFactory
     * @param CollectionFactory $categoryCollectionFactory
     */
    public function __construct(
        CategoryFactory $categoryFactory,
        CollectionFactory $categoryCollectionFactory
    ) {
        $this->categoryFactory = $categoryFactory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     * Retrieve a collection of active categories.
     *
     * @return \Magento\Catalog\Model\ResourceModel\Category\Collection
     */
    public function getCategoryCollection()
    {
        $collection = $this->categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addIsActiveFilter();

        return $collection;
    }

    /**
     * Convert category data to an option array.
     *
     * @return array
     */
    public function toOptionArray()
    {
        $categoryData = $this->convertToArray();
        $options = [];

        $options[] = [
            'value' => 0,
            'label' => __('All Categories')
        ];

        foreach ($categoryData as $key => $value) {
            $options[] = [
                'value' => $key,
                'label' => $value
            ];
        }

        return $options;
    }

    /**
     * Convert categories to an associative array.
     *
     * @return array
     */
    private function convertToArray()
    {
        $categories = $this->getCategoryCollection();

        $categoryList = [];
        foreach ($categories as $category) {
            $categoryList[$category->getEntityId()] = __(
                $this->getParentName($category->getPath()) . $category->getName()
            );
        }

        return $categoryList;
    }

    /**
     * Get the parent category names based on the category path.
     *
     * @param string $path
     * @return string
     */
    private function getParentName($path = '')
    {
        $parentName = '';
        $rootCats = [1, 2];

        $catTree = explode("/", $path);
        array_pop($catTree);

        if ($catTree && (count($catTree) > count($rootCats))) {
            foreach ($catTree as $catId) {
                if (!in_array($catId, $rootCats)) {
                    $category = $this->categoryFactory->create()->load($catId);
                    $categoryName = $category->getName();
                    $parentName .= $categoryName . ' -> ';
                }
            }
        }

        return $parentName;
    }
}
