<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MCategoriesRanges
 *
 * @ORM\Table(name="m_categories_ranges", indexes={@ORM\Index(name="ChildCategoryID", columns={"cr_category_child_id"}), @ORM\Index(name="ParentCategoryID", columns={"cr_category_parent_id"})})
 * @ORM\Entity
 */
class MCategoriesRanges
{
    /**
     * @var integer
     *
     * @ORM\Column(name="cr_range_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $crRangeId;

    /**
     * @var integer
     *
     * @ORM\Column(name="cr_category_parent_id", type="integer", nullable=false)
     */
    private $crCategoryParentId;

    /**
     * @var integer
     *
     * @ORM\Column(name="cr_category_child_id", type="integer", nullable=false)
     */
    private $crCategoryChildId;

    /**
     * @var string
     *
     * @ORM\Column(name="cr_range", type="string", length=30, nullable=false)
     */
    private $crRange;

    /**
     * @var integer
     *
     * @ORM\Column(name="cr_nb_performers", type="integer", nullable=false)
     */
    private $crNbPerformers;


}
