<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MEventsKeywords
 *
 * @ORM\Table(name="m_events_keywords", indexes={@ORM\Index(name="ek_keywords", columns={"ek_keywords"})})
 * @ORM\Entity
 */
class MEventsKeywords
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ek_event_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ekEventId;

    /**
     * @var string
     *
     * @ORM\Column(name="ek_keywords", type="text", nullable=true)
     */
    private $ekKeywords;


}
