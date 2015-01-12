<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MPerformers
 *
 * @ORM\Table(name="m_performers", indexes={@ORM\Index(name="performer_link_underscore", columns={"performer_link_underscore"}), @ORM\Index(name="performer_link_dash", columns={"performer_link_dash"}), @ORM\Index(name="performer_name", columns={"performer_name"})})
 * @ORM\Entity
 */
class MPerformers
{
    /**
     * @var integer
     *
     * @ORM\Column(name="performer_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $performerId;

    /**
     * @var string
     *
     * @ORM\Column(name="performer_name", type="string", length=255, nullable=false)
     */
    private $performerName;

    /**
     * @var string
     *
     * @ORM\Column(name="performer_link_underscore", type="string", length=255, nullable=true)
     */
    private $performerLinkUnderscore;

    /**
     * @var string
     *
     * @ORM\Column(name="performer_link_dash", type="string", length=255, nullable=true)
     */
    private $performerLinkDash;


}
