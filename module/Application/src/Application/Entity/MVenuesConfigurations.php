<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MVenuesConfigurations
 *
 * @ORM\Table(name="m_venues_configurations", indexes={@ORM\Index(name="fk_venues_configurations", columns={"vc_venue_id"}), @ORM\Index(name="fk_vc_vct", columns={"vc_vct_id"}), @ORM\Index(name="vc_map_id", columns={"vc_map_id"})})
 * @ORM\Entity
 */
class MVenuesConfigurations
{
    /**
     * @var integer
     *
     * @ORM\Column(name="vc_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $vcId;

    /**
     * @var \MVenuesConfigurationsTypes
     *
     * @ORM\ManyToOne(targetEntity="MVenuesConfigurationsTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vc_vct_id", referencedColumnName="vct_id")
     * })
     */
    private $vcVct;

    /**
     * @var \MVenues
     *
     * @ORM\ManyToOne(targetEntity="MVenues")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vc_venue_id", referencedColumnName="venue_id")
     * })
     */
    private $vcVenue;

    /**
     * @var \MMaps
     *
     * @ORM\ManyToOne(targetEntity="MMaps")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vc_map_id", referencedColumnName="map_id")
     * })
     */
    private $vcMap;


}
