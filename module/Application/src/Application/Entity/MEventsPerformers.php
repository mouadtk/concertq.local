<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MEventsPerformers
 *
 * @ORM\Table(name="m_events_performers", indexes={@ORM\Index(name="fk_events_performers", columns={"ep_performer_id"}), @ORM\Index(name="ep_event_id", columns={"ep_event_id"})})
 * @ORM\Entity
 */
class MEventsPerformers
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ep_event_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $epEventId;

    /**
     * @var integer
     *
     * @ORM\Column(name="ep_performer_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $epPerformerId;


}
