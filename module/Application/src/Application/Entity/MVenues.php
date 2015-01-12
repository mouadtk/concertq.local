<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MVenues
 *
 * @ORM\Table(name="m_venues", indexes={@ORM\Index(name="venue_city_id", columns={"venue_city_id"}), @ORM\Index(name="venue_zipcode", columns={"venue_zipcode"}), @ORM\Index(name="venue_link_underscore", columns={"venue_link_underscore"}), @ORM\Index(name="venue_link_dash", columns={"venue_link_dash"}), @ORM\Index(name="venue_name", columns={"venue_name"}), @ORM\Index(name="venue_rank", columns={"venue_rank"})})
 * @ORM\Entity
 */
class MVenues
{
    /**
     * @var integer
     *
     * @ORM\Column(name="venue_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $venueId;

    /**
     * @var string
     *
     * @ORM\Column(name="venue_name", type="string", length=255, nullable=false)
     */
    private $venueName;

    /**
     * @var string
     *
     * @ORM\Column(name="venue_link_underscore", type="string", length=255, nullable=true)
     */
    private $venueLinkUnderscore;

    /**
     * @var string
     *
     * @ORM\Column(name="venue_link_dash", type="string", length=255, nullable=true)
     */
    private $venueLinkDash;

    /**
     * @var string
     *
     * @ORM\Column(name="venue_address", type="string", length=255, nullable=true)
     */
    private $venueAddress;

    /**
     * @var integer
     *
     * @ORM\Column(name="venue_rank", type="integer", nullable=true)
     */
    private $venueRank;

    /**
     * @var \MCities
     *
     * @ORM\ManyToOne(targetEntity="MCities")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="venue_city_id", referencedColumnName="city_id")
     * })
     */
    private $venueCity;

    /**
     * @var \MZipcodes
     *
     * @ORM\ManyToOne(targetEntity="MZipcodes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="venue_zipcode", referencedColumnName="zipcode")
     * })
     */
    private $venueZipcode;


}
