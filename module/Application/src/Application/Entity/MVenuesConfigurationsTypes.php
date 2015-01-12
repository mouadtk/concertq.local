<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MVenuesConfigurationsTypes
 *
 * @ORM\Table(name="m_venues_configurations_types")
 * @ORM\Entity
 */
class MVenuesConfigurationsTypes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="vct_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $vctId;

    /**
     * @var string
     *
     * @ORM\Column(name="vct_name", type="string", length=100, nullable=false)
     */
    private $vctName;


}
