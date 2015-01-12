<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MCategories
 *
 * @ORM\Table(name="m_categories", uniqueConstraints={@ORM\UniqueConstraint(name="category_parent_id", columns={"category_parent_id", "category_child_id", "category_grandchild_id"})}, indexes={@ORM\Index(name="category_child_name", columns={"category_child_name"}), @ORM\Index(name="category_parent_id_2", columns={"category_parent_id"}), @ORM\Index(name="category_child_id", columns={"category_child_id"}), @ORM\Index(name="category_grandchild_id", columns={"category_grandchild_id"})})
 * @ORM\Entity
 */
class MCategories
{
    /**
     * @var integer
     *
     * @ORM\Column(name="category_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $categoryId;

    /**
     * @var integer
     *
     * @ORM\Column(name="category_parent_id", type="integer", nullable=false)
     */
    private $categoryParentId;

    /**
     * @var string
     *
     * @ORM\Column(name="category_parent_name", type="string", length=50, nullable=false)
     */
    private $categoryParentName;

    /**
     * @var integer
     *
     * @ORM\Column(name="category_child_id", type="integer", nullable=true)
     */
    private $categoryChildId;

    /**
     * @var string
     *
     * @ORM\Column(name="category_child_name", type="string", length=50, nullable=true)
     */
    private $categoryChildName;

    /**
     * @var integer
     *
     * @ORM\Column(name="category_grandchild_id", type="integer", nullable=true)
     */
    private $categoryGrandchildId;

    /**
     * @var string
     *
     * @ORM\Column(name="category_grandchild_name", type="string", length=50, nullable=true)
     */
    private $categoryGrandchildName;


}
