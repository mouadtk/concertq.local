<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MEvents
 *
 * @ORM\Table(name="m_events", indexes={@ORM\Index(name="event_date", columns={"event_date"}), @ORM\Index(name="event_time", columns={"event_time"}), @ORM\Index(name="performer_host_id", columns={"event_host_id"}), @ORM\Index(name="event_vc_id", columns={"event_vc_id"}), @ORM\Index(name="event_venue_id", columns={"event_venue_id"}), @ORM\Index(name="event_map_id", columns={"event_map_id"}), @ORM\Index(name="event_category_id", columns={"event_category_id"}), @ORM\Index(name="event_date_2", columns={"event_date", "event_time"})})
 * @ORM\Entity
 */
class MEvents
{
    /**
     * @var integer
     *
     * @ORM\Column(name="event_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $eventId;

    /**
     * @var string
     *
     * @ORM\Column(name="event_name", type="string", length=200, nullable=false)
     */
    private $eventName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="event_date", type="date", nullable=false)
     */
    private $eventDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="event_time", type="time", nullable=false)
     */
    private $eventTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="event_insert_time", type="datetime", nullable=false)
     */
    private $eventInsertTime = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="event_host_id", type="integer", nullable=true)
     */
    private $eventHostId;

    /**
     * @var integer
     *
     * @ORM\Column(name="event_vc_id", type="integer", nullable=true)
     */
    private $eventVcId;

    /**
     * @var integer
     *
     * @ORM\Column(name="event_venue_id", type="integer", nullable=true)
     */
    private $eventVenueId;

    /**
     * @var integer
     *
     * @ORM\Column(name="event_map_id", type="integer", nullable=true)
     */
    private $eventMapId;

    /**
     * @var integer
     *
     * @ORM\Column(name="event_category_id", type="integer", nullable=true)
     */
    private $eventCategoryId;


}
