<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MStates
 *
 * @ORM\Table(name="m_states", indexes={@ORM\Index(name="state_country_id", columns={"state_country_id"}), @ORM\Index(name="state_link_underscore", columns={"state_link_underscore"}), @ORM\Index(name="state_link_dash", columns={"state_link_dash"})})
 * @ORM\Entity
 */
class MStates
{
    /**
     * @var integer
     *
     * @ORM\Column(name="state_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $stateId;

    /**
     * @var string
     *
     * @ORM\Column(name="state_name", type="string", length=50, nullable=false)
     */
    private $stateName;

    /**
     * @var string
     *
     * @ORM\Column(name="state_link_underscore", type="string", length=50, nullable=false)
     */
    private $stateLinkUnderscore;

    /**
     * @var string
     *
     * @ORM\Column(name="state_link_dash", type="string", length=50, nullable=false)
     */
    private $stateLinkDash;

    /**
     * @var string
     *
     * @ORM\Column(name="state_abbreviation", type="string", length=10, nullable=true)
     */
    private $stateAbbreviation;

    /**
     * @var \MCountries
     *
     * @ORM\ManyToOne(targetEntity="MCountries")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="state_country_id", referencedColumnName="country_id")
     * })
     */
    private $stateCountry;


}
