<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MGeolocation
 *
 * @ORM\Table(name="m_geolocation", indexes={@ORM\Index(name="fk_geolocation_zipcodes", columns={"geolocation_zipcode"})})
 * @ORM\Entity
 */
class MGeolocation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="geolocation_ip_group", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $geolocationIpGroup;

    /**
     * @var \MZipcodes
     *
     * @ORM\ManyToOne(targetEntity="MZipcodes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="geolocation_zipcode", referencedColumnName="zipcode")
     * })
     */
    private $geolocationZipcode;


}
