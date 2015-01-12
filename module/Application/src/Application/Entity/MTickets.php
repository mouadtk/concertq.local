<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MTickets
 *
 * @ORM\Table(name="m_tickets")
 * @ORM\Entity
 */
class MTickets
{
    /**
     * @var string
     *
     * @ORM\Column(name="ticket_info", type="text", nullable=false)
     */
    private $ticketInfo;

    /**
     * @var float
     *
     * @ORM\Column(name="ticket_min_price", type="float", precision=10, scale=0, nullable=false)
     */
    private $ticketMinPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="ticket_max_price", type="float", precision=10, scale=0, nullable=false)
     */
    private $ticketMaxPrice;

    /**
     * @var integer
     *
     * @ORM\Column(name="ticket_count", type="integer", nullable=false)
     */
    private $ticketCount;

    /**
     * @var string
     *
     * @ORM\Column(name="ticket_event_notes", type="text", nullable=true)
     */
    private $ticketEventNotes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ticket_insert_time", type="datetime", nullable=false)
     */
    private $ticketInsertTime = 'CURRENT_TIMESTAMP';

    /**
     * @var \MEvents
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="MEvents")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ticket_event_id", referencedColumnName="event_id")
     * })
     */
    private $ticketEvent;


}
