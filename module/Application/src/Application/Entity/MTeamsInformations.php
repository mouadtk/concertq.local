<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MTeamsInformations
 *
 * @ORM\Table(name="m_teams_informations", indexes={@ORM\Index(name="fk_teams_info_venues", columns={"ti_venue_id"}), @ORM\Index(name="fk_teams_informations", columns={"ti_division_id"})})
 * @ORM\Entity
 */
class MTeamsInformations
{
    /**
     * @var string
     *
     * @ORM\Column(name="ti_abbreviation", type="string", length=100, nullable=true)
     */
    private $tiAbbreviation;

    /**
     * @var string
     *
     * @ORM\Column(name="ti_abbreviation_2", type="string", length=100, nullable=true)
     */
    private $tiAbbreviation2;

    /**
     * @var integer
     *
     * @ORM\Column(name="ti_division_id", type="integer", nullable=true)
     */
    private $tiDivisionId;

    /**
     * @var \MPerformers
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="MPerformers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ti_performer_id", referencedColumnName="performer_id")
     * })
     */
    private $tiPerformer;

    /**
     * @var \MVenues
     *
     * @ORM\ManyToOne(targetEntity="MVenues")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ti_venue_id", referencedColumnName="venue_id")
     * })
     */
    private $tiVenue;


}
