<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MCities
 *
 * @ORM\Table(name="m_cities", indexes={@ORM\Index(name="city_link_underscore", columns={"city_link_underscore"}), @ORM\Index(name="city_link_dash", columns={"city_link_dash"}), @ORM\Index(name="city_state_id", columns={"city_state_id"}), @ORM\Index(name="city_country_id", columns={"city_country_id"}), @ORM\Index(name="city_name", columns={"city_name", "city_state_id", "city_country_id"}), @ORM\Index(name="city_name_2", columns={"city_name"}), @ORM\Index(name="city_rank", columns={"city_rank"})})
 * @ORM\Entity
 */
class MCities
{
    /**
     * @var integer
     *
     * @ORM\Column(name="city_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $cityId;

    /**
     * @var string
     *
     * @ORM\Column(name="city_name", type="string", length=255, nullable=false)
     */
    private $cityName;

    /**
     * @var string
     *
     * @ORM\Column(name="city_link_underscore", type="string", length=255, nullable=true)
     */
    private $cityLinkUnderscore;

    /**
     * @var string
     *
     * @ORM\Column(name="city_link_dash", type="string", length=255, nullable=true)
     */
    private $cityLinkDash;

    /**
     * @var string
     *
     * @ORM\Column(name="city_abbreviation", type="string", length=50, nullable=true)
     */
    private $cityAbbreviation;

    /**
     * @var float
     *
     * @ORM\Column(name="city_latitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $cityLatitude = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="city_longitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $cityLongitude = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="city_state_id", type="integer", nullable=true)
     */
    private $cityStateId;

    /**
     * @var integer
     *
     * @ORM\Column(name="city_country_id", type="integer", nullable=true)
     */
    private $cityCountryId;

    /**
     * @var integer
     *
     * @ORM\Column(name="city_rank", type="integer", nullable=true)
     */
    private $cityRank;


}
