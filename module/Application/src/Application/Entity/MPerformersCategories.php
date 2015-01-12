<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MPerformersCategories
 *
 * @ORM\Table(name="m_performers_categories", indexes={@ORM\Index(name="pc_category_id", columns={"pc_category_id"}), @ORM\Index(name="performer_rank", columns={"pc_rank"}), @ORM\Index(name="pc_cr_id", columns={"pc_cr_range_id"}), @ORM\Index(name="IDX_781878A318776461", columns={"pc_performer_id"})})
 * @ORM\Entity
 */
class MPerformersCategories
{
    /**
     * @var integer
     *
     * @ORM\Column(name="pc_rank", type="integer", nullable=true)
     */
    private $pcRank;

    /**
     * @var \MPerformers
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="MPerformers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pc_performer_id", referencedColumnName="performer_id")
     * })
     */
    private $pcPerformer;

    /**
     * @var \MCategories
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="MCategories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pc_category_id", referencedColumnName="category_id")
     * })
     */
    private $pcCategory;

    /**
     * @var \MCategoriesRanges
     *
     * @ORM\ManyToOne(targetEntity="MCategoriesRanges")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pc_cr_range_id", referencedColumnName="cr_range_id")
     * })
     */
    private $pcCrRange;


}
