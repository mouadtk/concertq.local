<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MZipcodes
 *
 * @ORM\Table(name="m_zipcodes", indexes={@ORM\Index(name="zipcode_latitude", columns={"zipcode_latitude", "zipcode_longitude"}), @ORM\Index(name="zipcode_latitude_2", columns={"zipcode_latitude"}), @ORM\Index(name="zipcode_longitude", columns={"zipcode_longitude"})})
 * @ORM\Entity
 */
class MZipcodes
{
    /**
     * @var string
     *
     * @ORM\Column(name="zipcode", type="string", length=20, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $zipcode;

    /**
     * @var float
     *
     * @ORM\Column(name="zipcode_latitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $zipcodeLatitude = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="zipcode_longitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $zipcodeLongitude = '0';


}
